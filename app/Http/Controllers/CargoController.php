<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Exports\CargoExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CargoController extends Controller
{
    public function index(Request $request)
    {
        $query = Cargo::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_perusahaan', 'like', "%{$search}%")
                  ->orWhere('no_bl', 'like', "%{$search}%")
                  ->orWhere('marking', 'like', "%{$search}%")
                  ->orWhere('cargo', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cargos = $query->latest()->paginate(10)->appends($request->query());

        return view('cargo.index', compact('cargos'));
    }

    public function create()
    {
        return view('cargo.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'no_bl' => 'required|string|max:255',
            'party' => 'required|integer|min:1',
            'marking' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:proses,complete',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $this->storePublicPhoto($request);
        }

        Cargo::create($validated);

        return redirect()->route('cargo.index')->with('success', 'Data cargo berhasil ditambahkan!');
    }

    public function show(Cargo $cargo)
    {
        return view('cargo.show', compact('cargo'));
    }

    public function edit(Cargo $cargo)
    {
        return view('cargo.edit', compact('cargo'));
    }

    public function update(Request $request, Cargo $cargo)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'no_bl' => 'required|string|max:255',
            'party' => 'required|integer|min:1',
            'marking' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:proses,complete',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($cargo->foto) {
                $this->deletePublicPhoto($cargo->foto);
            }
            $validated['foto'] = $this->storePublicPhoto($request);
        }

        $cargo->update($validated);

        return redirect()->route('cargo.index')->with('success', 'Data cargo berhasil diperbarui!');
    }

    public function destroy(Cargo $cargo)
    {
        if ($cargo->foto) {
            $this->deletePublicPhoto($cargo->foto);
        }
        $cargo->delete();

        return redirect()->route('cargo.index')->with('success', 'Data cargo berhasil dihapus!');
    }

    public function exportPdf(Request $request)
    {
        $query = Cargo::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $cargos = $query->latest()->get();

        $pdf = Pdf::loadView('cargo.pdf', compact('cargos'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('data-cargo-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new CargoExport($request->status), 'data-cargo-' . now()->format('Y-m-d') . '.xlsx');
    }

    private function storePublicPhoto(Request $request): string
    {
        $file = $request->file('foto');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        File::ensureDirectoryExists(public_path('cargo-photos'));
        $file->move(public_path('cargo-photos'), $filename);

        return 'cargo-photos/' . $filename;
    }

    private function deletePublicPhoto(string $path): void
    {
        $path = ltrim($path, '/');
        $path = Str::replaceFirst('storage/', '', $path);
        $path = Str::replaceFirst('public/', '', $path);

        if (!Str::contains($path, '/')) {
            $path = 'cargo-photos/' . $path;
        }

        $publicPath = public_path($path);

        if (File::exists($publicPath)) {
            File::delete($publicPath);
        }
    }
}

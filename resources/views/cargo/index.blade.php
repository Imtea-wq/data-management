@extends('layouts.app')

@section('title', 'Data Cargo - Data Management Cargo')
@section('page-title', 'Data Cargo')
@section('page-subtitle', 'Kelola semua data pengiriman cargo')

@section('content')
<!-- Action Bar -->
<div class="card-panel mb-4 fade-in">
    <div class="card-panel-body">
        <div class="row align-items-center g-3">
            <div class="col-lg-4">
                <form action="{{ route('cargo.index') }}" method="GET" class="search-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" class="form-control form-control-custom"
                           placeholder="Cari perusahaan, BL, marking..."
                           value="{{ request('search') }}"
                           id="searchInput">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                </form>
            </div>
            <div class="col-lg-3">
                <form action="{{ route('cargo.index') }}" method="GET" id="filterForm">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <select name="status" class="form-select form-select-custom" onchange="document.getElementById('filterForm').submit()" id="statusFilter">
                        <option value="">Semua Status</option>
                        <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="complete" {{ request('status') == 'complete' ? 'selected' : '' }}>Complete</option>
                    </select>
                </form>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex gap-2 justify-content-lg-end flex-wrap">
                    <a href="{{ route('cargo.create') }}" class="btn-primary-custom" id="btnAddCargo">
                        <i class="bi bi-plus-lg"></i> Tambah Data
                    </a>
                    <a href="{{ route('cargo.export.pdf', request()->query()) }}" class="btn-outline-custom" id="btnExportPdf">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>
                    <a href="{{ route('cargo.export.excel', request()->query()) }}" class="btn-outline-custom" id="btnExportExcel">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card-panel fade-in">
    <div class="card-panel-header">
        <h5><i class="bi bi-table text-primary"></i> Tabel Data Cargo</h5>
        <span class="text-muted" style="font-size: 0.82rem;">Total: {{ $cargos->total() }} data</span>
    </div>
    <div class="card-panel-body p-0">
        <div class="table-responsive">
            <table class="table table-modern" id="cargoTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Perusahaan</th>
                        <th>No BL</th>
                        <th>Party</th>
                        <th>Marking</th>
                        <th>Cargo</th>
                        <th>Lokasi</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cargos as $i => $cargo)
                    <tr>
                        <td>{{ $cargos->firstItem() + $i }}</td>
                        <td><strong>{{ $cargo->nama_perusahaan }}</strong></td>
                        <td><code style="background: #f1f5f9; padding: 2px 8px; border-radius: 4px; font-size: 0.82rem;">{{ $cargo->no_bl }}</code></td>
                        <td>{{ $cargo->party }}</td>
                        <td>{{ $cargo->marking }}</td>
                        <td>{{ $cargo->cargo }}</td>
                        <td style="max-width: 150px;">
                            <span title="{{ $cargo->lokasi }}">{{ Str::limit($cargo->lokasi, 30) }}</span>
                        </td>
                        <td>
                            @if($cargo->foto_url)
                                <img src="{{ $cargo->foto_url }}" alt="Foto Cargo" class="photo-thumb">
                            @else
                                <span class="text-muted" style="font-size: 0.8rem;">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-status {{ $cargo->status === 'proses' ? 'badge-proses' : 'badge-complete' }}">
                                <i class="bi {{ $cargo->status === 'proses' ? 'bi-hourglass-split' : 'bi-check-circle' }}"></i>
                                {{ ucfirst($cargo->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('cargo.edit', $cargo) }}" class="btn-warning-custom" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('cargo.destroy', $cargo) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger-custom" title="Hapus">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3 mb-1" style="font-size: 1rem; font-weight: 600;">Data Tidak Ditemukan</p>
                            <p class="text-muted mb-3" style="font-size: 0.85rem;">Belum ada data cargo atau tidak sesuai filter.</p>
                            <a href="{{ route('cargo.create') }}" class="btn-primary-custom">
                                <i class="bi bi-plus-lg"></i> Tambah Data Baru
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($cargos->hasPages())
    <div class="card-panel-body border-top pt-3">
        <div class="d-flex justify-content-center">
            {{ $cargos->links('pagination::bootstrap-5') }}
        </div>
    </div>
    @endif
</div>
@endsection

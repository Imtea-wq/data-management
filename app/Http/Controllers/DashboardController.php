<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalData = Cargo::count();
        $dataProses = Cargo::proses()->count();
        $dataComplete = Cargo::complete()->count();

        // Data grafik cargo per bulan (12 bulan terakhir)
        $chartData = Cargo::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan"),
                DB::raw("SUM(CASE WHEN status = 'proses' THEN 1 ELSE 0 END) as proses"),
                DB::raw("SUM(CASE WHEN status = 'complete' THEN 1 ELSE 0 END) as complete"),
                DB::raw("COUNT(*) as total")
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $labels = $chartData->pluck('bulan')->map(function ($item) {
            $parts = explode('-', $item);
            $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            return $months[(int)$parts[1] - 1] . ' ' . $parts[0];
        });
        $prosesData = $chartData->pluck('proses');
        $completeData = $chartData->pluck('complete');

        // Data cargo terbaru
        $recentCargos = Cargo::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalData', 'dataProses', 'dataComplete',
            'labels', 'prosesData', 'completeData', 'recentCargos'
        ));
    }
}

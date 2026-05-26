@extends('layouts.app')

@section('title', 'Dashboard - Data Management Cargo')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data pengiriman cargo')

@section('content')
<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4 fade-in stagger-1">
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="bi bi-box-seam-fill"></i>
            </div>
            <div class="stat-value">{{ $totalData }}</div>
            <div class="stat-label">Total Data Cargo</div>
        </div>
    </div>
    <div class="col-md-4 fade-in stagger-2">
        <div class="stat-card proses">
            <div class="stat-icon">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-value">{{ $dataProses }}</div>
            <div class="stat-label">Sedang Proses</div>
        </div>
    </div>
    <div class="col-md-4 fade-in stagger-3">
        <div class="stat-card complete">
            <div class="stat-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="stat-value">{{ $dataComplete }}</div>
            <div class="stat-label">Selesai / Complete</div>
        </div>
    </div>
</div>

<!-- Chart -->
<div class="row g-4 mb-4">
    <div class="col-lg-8 fade-in">
        <div class="card-panel">
            <div class="card-panel-header">
                <h5><i class="bi bi-bar-chart-line-fill text-primary"></i> Grafik Cargo Per Bulan</h5>
            </div>
            <div class="card-panel-body">
                <canvas id="cargoChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 fade-in">
        <div class="card-panel">
            <div class="card-panel-header">
                <h5><i class="bi bi-pie-chart-fill text-primary"></i> Status Cargo</h5>
            </div>
            <div class="card-panel-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Data -->
<div class="row">
    <div class="col-12 fade-in">
        <div class="card-panel">
            <div class="card-panel-header">
                <h5><i class="bi bi-clock-history text-primary"></i> Data Terbaru</h5>
                <a href="{{ route('cargo.index') }}" class="btn-outline-custom">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-panel-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Perusahaan</th>
                                <th>No BL</th>
                                <th>Cargo</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentCargos as $i => $cargo)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td><strong>{{ $cargo->nama_perusahaan }}</strong></td>
                                <td>{{ $cargo->no_bl }}</td>
                                <td>{{ $cargo->cargo }}</td>
                                <td>
                                    <span class="badge-status {{ $cargo->status === 'proses' ? 'badge-proses' : 'badge-complete' }}">
                                        <i class="bi {{ $cargo->status === 'proses' ? 'bi-hourglass-split' : 'bi-check-circle' }}"></i>
                                        {{ ucfirst($cargo->status) }}
                                    </span>
                                </td>
                                <td>{{ $cargo->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox text-muted" style="font-size: 2.5rem;"></i>
                                    <p class="text-muted mt-2 mb-0">Belum ada data cargo</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
    // Bar Chart - Cargo per bulan
    const ctx = document.getElementById('cargoChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Proses',
                    data: {!! json_encode($prosesData) !!},
                    backgroundColor: 'rgba(245, 158, 11, 0.7)',
                    borderColor: 'rgba(245, 158, 11, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                },
                {
                    label: 'Complete',
                    data: {!! json_encode($completeData) !!},
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1,
                    borderRadius: 6,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { family: 'Inter', size: 12, weight: '500' }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { family: 'Inter', size: 11 }
                    },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                },
                x: {
                    ticks: { font: { family: 'Inter', size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });

    // Doughnut Chart - Status
    const ctx2 = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Proses', 'Complete'],
            datasets: [{
                data: [{{ $dataProses }}, {{ $dataComplete }}],
                backgroundColor: [
                    'rgba(245, 158, 11, 0.8)',
                    'rgba(16, 185, 129, 0.8)'
                ],
                borderColor: ['#fff', '#fff'],
                borderWidth: 3,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { family: 'Inter', size: 12, weight: '500' }
                    }
                }
            }
        }
    });
</script>
@endpush

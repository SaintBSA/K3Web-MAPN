<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelaporan K3 - MAPN Group</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* Gaya Kustom dari HTML Anda */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7f9;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #ffffff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.05);
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .card-k3 {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        .card-k3:hover {
            transform: translateY(-3px);
        }
        .report-number {
            font-size: 3rem;
            font-weight: 700;
        }
        /* Warna untuk Status */
        .status-total { color: #212529; }
        .status-pending { color: #ffc107; }
        .status-closed { color: #28a745; }
        
        .nav-link.active {
            background-color: #e6f7ff !important;
            color: #0d6efd !important;
            border-left: 4px solid #0d6efd;
            font-weight: 600;
        }
        .nav-link {
            transition: all 0.2s;
        }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column">
        <div class="p-3 mb-4 text-center">
            <h5 class="fw-bold text-primary">K3 MAPN System ({{ strtoupper(Auth::user()->role) }})</h5>
        </div>
        <nav class="nav flex-column px-3">
            <a class="nav-link active rounded mb-1" href="{{ route('home') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            
            {{-- FITUR 3: INPUT FORM LAPORAN (Hanya Admin) --}}
            @if(Auth::user()->role === 'admin')
                <a class="nav-link text-dark rounded mb-1" href="{{ route('reports.create') }}">
                    <i class="bi bi-file-earmark-text me-2"></i> Laporan Baru
                </a>
            @endif

            {{-- FITUR 5: LIHAT RIWAYAT DETAIL LAPORAN (Admin & SPV) --}}
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'spv')
                <a class="nav-link text-dark rounded mb-1" href="{{ route('reports.index') }}">
                    <i class="bi bi-card-checklist me-2"></i> Semua Laporan
                </a>
            @endif

            <a class="nav-link text-dark rounded mb-1" href="#">
                <i class="bi bi-gear me-2"></i> Pengaturan (WIP)
            </a>
            
            <a class="nav-link text-danger mt-4 rounded" href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar
            </a>
             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>
    </div>

    <div class="main-content">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold">Dashboard Pelaporan K3</h1>
            
            {{-- Tombol Ajukan Laporan (Hanya Admin) --}}
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('reports.create') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-plus me-1"></i> Ajukan Laporan Baru
                </a>
            @endif
        </div>

        {{-- RINGKASAN DATA DARI DATABASE --}}
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card card-k3 p-3">
                    <p class="text-muted mb-1">Total Laporan</p>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-text status-total fs-4 me-3"></i>
                        <span class="report-number status-total">{{ $totalReports }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-k3 p-3">
                    <p class="text-muted mb-1">Laporan Tertunda (Pending)</p>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock status-pending fs-4 me-3"></i>
                        <span class="report-number status-pending">{{ $pendingReports }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-k3 p-3">
                    <p class="text-muted mb-1">Laporan Selesai (Closed)</p>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle status-closed fs-4 me-3"></i>
                        <span class="report-number status-closed">{{ $closedReports }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- GRAFIK (Menggunakan Data Dummy Kustom Anda) --}}
        <div class="row mb-5">
            <div class="col-md-8">
                <div class="card card-k3 p-4">
                    <h5 class="fw-bold mb-3">Tren Pelaporan Bulanan (6 Bulan Terakhir)</h5>
                    <canvas id="monthlyTrendChart" height="120"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-k3 p-4">
                    <h5 class="fw-bold mb-3">Laporan Berdasarkan Jenis Insiden</h5>
                    <canvas id="incidentTypeChart"></canvas>
                </div>
            </div>
        </div>

        {{-- TABEL LAPORAN PENDING MENDESAK DARI DATABASE --}}
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'spv')
        <div class="row">
            <div class="col-12">
                <div class="card card-k3 p-4">
                    <h5 class="fw-bold mb-3">Laporan Tertunda Paling Mendesak</h5>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Jenis Insiden</th>
                                    <th>Prioritas</th>
                                    <th>Tanggal Lapor</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($chartData['urgentReports'] as $report)
                                <tr>
                                    <td>K3-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $report->type }}</td>
                                    <td>
                                        <span class="badge text-bg-{{ strtolower($report->priority) == 'tinggi' ? 'danger' : (strtolower($report->priority) == 'sedang' ? 'warning' : 'secondary') }}">
                                            {{ $report->priority }}
                                        </span>
                                    </td>
                                    <td>{{ $report->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('reports.show', $report->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                        {{-- Hanya SPV yang bisa mengubah status --}}
                                        @if(Auth::user()->role === 'spv')
                                            <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-sm btn-outline-warning">Ubah Status</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada laporan Pending yang mendesak.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- SCRIPTS BAWAAN ANDA --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Data Dummy untuk Grafik (Dibiarkan sama, karena ini adalah contoh data)
        const monthlyData = {
            labels: ['Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep'],
            datasets: [{
                label: 'Jumlah Laporan K3',
                data: [180, 150, 210, 195, 230, 15], 
                backgroundColor: 'rgba(13, 110, 253, 0.5)',
                borderColor: '#0d6efd',
                borderWidth: 2,
                borderRadius: 5,
                fill: true,
                tension: 0.3
            }]
        };

        const incidentTypeData = {
            labels: ['Kecelakaan Kerja', 'Nyaris Celaka', 'Kerusakan Properti', 'Bahaya Lingkungan'],
            datasets: [{
                label: 'Jenis Insiden',
                data: [35, 45, 15, 5], 
                backgroundColor: [
                    '#dc3545', 
                    '#ffc107', 
                    '#0d6efd', 
                    '#28a745'
                ],
                hoverOffset: 4
            }]
        };

        // Inisialisasi Grafik 1: Tren Bulanan
        new Chart(document.getElementById('monthlyTrendChart'), {
            type: 'bar',
            data: monthlyData,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Inisialisasi Grafik 2: Jenis Insiden
        new Chart(document.getElementById('incidentTypeChart'), {
            type: 'doughnut',
            data: incidentTypeData,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    title: { display: false }
                },
            }
        });
    </script>
</body>
</html>
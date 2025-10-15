<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan K3: K3-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* Gaya CSS dari halaman Edit/Dashboard Anda */
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
        .nav-link {
            transition: all 0.2s;
        }
        .nav-link.active {
            background-color: #e6f7ff !important;
            color: #0d6efd !important;
            border-left: 4px solid #0d6efd;
            font-weight: 600;
        }
        .card-detail {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        .data-label {
            font-weight: 600;
            color: #343a40;
        }
        .data-value {
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="sidebar d-flex flex-column">
        <div class="p-3 mb-4 text-center">
            <h5 class="fw-bold text-primary">K3 MAPN System ({{ strtoupper(Auth::user()->role) }})</h5>
        </div>
        <nav class="nav flex-column px-3">
            <a class="nav-link text-dark rounded mb-1" href="{{ route('home') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            
            {{-- Navigasi Lainnya Sesuai Role --}}
            @if(Auth::user()->role === 'admin')
                <a class="nav-link text-dark rounded mb-1" href="{{ route('reports.create') }}">
                    <i class="bi bi-file-earmark-text me-2"></i> Laporan Baru
                </a>
            @endif

            <a class="nav-link text-dark rounded mb-1" href="{{ route('reports.index') }}">
                <i class="bi bi-card-checklist me-2"></i> Semua Laporan
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
        
        <h1 class="h3 fw-bold mb-2">Detail Laporan K3: K3-{{ str_pad($report->id, 4, '0', STR_PAD_LEFT) }}</h1>
        <p class="text-muted mb-4">Laporan Diajukan oleh {{ $report->reported_by }} pada {{ $report->created_at->format('d F Y') }}</p>

        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-secondary mb-4">
             <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Laporan
        </a>

        <div class="card card-detail p-4">
            
            <h5 class="mb-3 text-primary fw-semibold">Informasi Kejadian</h5>
            <hr>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <p class="data-label">Tanggal Lapor:</p>
                    <p class="data-value">{{ $report->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                <div class="col-md-6 mb-3">
                    <p class="data-label">Waktu Kejadian:</p>
                    <p class="data-value">{{ $report->incident_datetime ? \Carbon\Carbon::parse($report->incident_datetime)->format('d M Y, H:i') : 'N/A' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <p class="data-label">Lokasi Kejadian:</p>
                    <p class="data-value">{{ $report->location }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p class="data-label">Jenis Insiden:</p>
                    <p class="data-value">{{ $report->type }}</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <p class="data-label">Perkiraan Dampak:</p>
                    <p class="data-value">{{ $report->impact }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p class="data-label">Dilaporkan Oleh:</p>
                    <p class="data-value">{{ $report->reported_by }}</p>
                </div>
            </div>
            
            <p class="data-label mt-3">Keterangan/Deskripsi Insiden:</p>
            <div class="alert alert-light border p-3 data-value">{{ $report->description }}</div>

            <p class="data-label mt-3">Pihak/Orang yang Terlibat (Selain Pelapor):</p>
            <p class="data-value">{{ $report->involved_parties ?? 'Tidak ada data pihak terlibat.' }}</p>

            {{-- STATUS DAN PRIORITAS SAAT INI (Bisa dilihat Admin) --}}
            <h5 class="mt-4 mb-3 text-success fw-semibold">Status & Keputusan K3</h5>
            <hr>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <p class="data-label">Status Saat Ini:</p>
                    @php
                        $statusColor = ['Pending' => 'warning', 'In Progress' => 'info', 'Closed' => 'success', 'Overdue' => 'danger', 'Not Applicable' => 'secondary'];
                        $currentStatusColor = $statusColor[$report->status] ?? 'secondary';
                    @endphp
                    <span class="badge text-bg-{{ $currentStatusColor }} fs-6">{{ $report->status }}</span>
                </div>
                <div class="col-md-4 mb-3">
                    <p class="data-label">Prioritas K3:</p>
                    @php
                        $priorityColor = ['Tinggi' => 'danger', 'Sedang' => 'warning', 'Rendah' => 'secondary'];
                        $currentPriorityColor = $priorityColor[$report->priority] ?? 'secondary';
                    @endphp
                    <span class="badge text-bg-{{ $currentPriorityColor }} fs-6">{{ $report->priority }}</span>
                </div>
            </div>


            {{-- LAMPIRAN BUKTI --}}
            <h5 class="mt-4 mb-3 text-primary fw-semibold">Lampiran Bukti</h5>
            <hr>

            <div class="mb-4">
                @if($report->media_path)
                    @php
                        $extension = pathinfo($report->media_path, PATHINFO_EXTENSION);
                        $extension = strtoupper($extension); // Untuk tampilan: PNG, JPG, MP4
                    @endphp
                    <p class="ms-2">
                        <i class="bi bi-paperclip me-1"></i> 
                        <a href="{{ asset('storage/' . $report->media_path) }}" target="_blank">
                            Lihat File Bukti ({{ $extension }})
                        </a>
                    </p>
                    
                    {{-- Hapus div mt-2 yang berisi tag <img> dan <video> --}}
                    
                @else
                    <p class="ms-2 text-muted">Tidak ada lampiran yang diunggah.</p>
                @endif
            </div>

            {{-- Tombol Aksi (Hanya muncul jika SPV) --}}
            @if(Auth::user()->role === 'spv')
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-warning me-md-2">
                         <i class="bi bi-pencil-square me-1"></i> Lanjutkan Peninjauan (Ubah Status)
                    </a>
                </div>
            @endif

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Laporan Baru - MAPN Group</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        /* Style Dasar dan Sidebar (Diambil dari Dashboard) */
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
        .nav-link.active {
            background-color: #e6f7ff !important;
            color: #0d6efd !important;
            border-left: 4px solid #0d6efd;
            font-weight: 600;
        }
        .nav-link {
            transition: all 0.2s;
        }
        /* Gaya Khusus untuk Form */
        .card-form {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
        }
        .btn-k3-submit {
            background-color: #28a745;
            border-color: #28a745;
            font-weight: 600;
            border-radius: 8px;
        }
        .btn-k3-submit:hover {
            background-color: #1e7e34;
            border-color: #1e7e34;
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
            <a class="nav-link active rounded mb-1" href="{{ route('reports.create') }}">
                <i class="bi bi-file-earmark-text me-2"></i> Laporan Baru
            </a>
            <a class="nav-link text-dark rounded mb-1" href="{{ route('reports.index') }}">
                <i class="bi bi-card-checklist me-2"></i> Semua Laporan
            </a>
            <a class="nav-link text-dark rounded mb-1" href="#">
                <i class="bi bi-gear me-2"></i> Pengaturan
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
        
        <h1 class="h3 fw-bold mb-4">Formulir Pengajuan Laporan K3</h1>
        <p class="text-muted mb-4">Mohon isi formulir ini dengan detail dan akurat untuk meminimalkan risiko kecelakaan kerja dan bahaya di lingkungan pabrik.</p>

        <div class="card card-form p-4">
            {{-- FORM SUBMIT LARAVEL --}}
            <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <h5 class="mb-3 text-primary fw-semibold">Informasi Kejadian</h5>
                <hr>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="incident_datetime" class="form-label fw-semibold">Tanggal & Waktu Kejadian <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('incident_datetime') is-invalid @enderror" id="incident_datetime" name="incident_datetime" required>
                        @error('incident_datetime') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="location" class="form-label fw-semibold">Lokasi Kejadian <span class="text-danger">*</span></label>
                        <select class="form-select @error('location') is-invalid @enderror" id="location" name="location" required>
                            <option selected disabled value="">Pilih Lokasi</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->name }}" {{ old('location') == $location->name ? 'selected' : '' }}>
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <h5 class="mt-4 mb-3 text-primary fw-semibold">Detail Insiden</h5>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label fw-semibold">Jenis Insiden <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option selected disabled value="">Pilih Jenis Insiden</option>
                            @foreach($types as $type)
                                <option value="{{ $type->name }}" {{ old('type') == $type->name ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="impact" class="form-label fw-semibold">Perkiraan Dampak <span class="text-danger">*</span></label>
                        <select class="form-select @error('impact') is-invalid @enderror" id="impact" name="impact" required>
                            <option selected disabled value="">Pilih Tingkat Dampak</option>
                            @foreach($impacts as $impact)
                                <option value="{{ $impact->name }}" {{ old('impact') == $impact->name ? 'selected' : '' }}>
                                    {{ $impact->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('impact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Keterangan/Deskripsi Insiden <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Jelaskan secara detail apa yang terjadi, bagaimana, dan mengapa..." required>{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="media" class="form-label fw-semibold">Foto/Video Bukti (Opsional)</label>
                    {{-- Diubah ke name="media" untuk satu file upload --}}
                    <input class="form-control @error('media') is-invalid @enderror" type="file" id="media" name="media">
                    <small class="form-text text-muted">Maks. 1 file. Format: JPG, PNG, MP4. Ukuran maks. 20MB.</small>
                    @error('media') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <h5 class="mt-4 mb-3 text-primary fw-semibold">Informasi Pelapor & Status</h5>
                <hr>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="namaPelapor" class="form-label fw-semibold">Nama Pelapor</label>
                        {{-- Mengambil nama pengguna yang login --}}
                        <input type="text" class="form-control" id="namaPelapor" value="{{ Auth::user()->name }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="involved_parties" class="form-label fw-semibold">Pihak/Orang yang Terlibat (Selain Pelapor)</label>
                        <input type="text" class="form-control @error('involved_parties') is-invalid @enderror" id="involved_parties" name="involved_parties" placeholder="Contoh: Amir (Operator Mesin 3), Joko (Maintenance)" value="{{ old('involved_parties') }}">
                        @error('involved_parties') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label fw-semibold">Status Insiden</label>
                        <select class="form-select" id="status" name="status" disabled>
                            <option value="Pending" selected>Pending (Menunggu Review K3)</option>
                        </select>
                        {{-- Laravel akan menggunakan nilai ini di Controller --}}
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="prioritas" class="form-label fw-semibold">Prioritas Insiden</label>
                        <select class="form-select" id="prioritas" name="prioritas" disabled>
                            <option value="Rendah" selected>Rendah (Ditentukan Otomatis)</option>
                        </select>
                        {{-- Laravel akan menggunakan nilai ini di Controller --}}
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg btn-k3-submit">
                        <i class="bi bi-send-fill me-2"></i> Kirim Laporan K3
                    </button>
                </div>

            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
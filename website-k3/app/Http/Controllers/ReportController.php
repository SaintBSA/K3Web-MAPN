<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\MasterOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{

    public function index()
    {
        $reports = Report::all();
        return view('reports.index', compact('reports'));

        // Mengambil data ringkasan
    $totalReports = Report::count();
    $pendingReports = Report::where('status', 'Pending')->count();
    $closedReports = Report::where('status', 'Closed')->count();

    // Data dummy untuk Chart.js (karena logika data real-time kompleks)
    // Anda bisa mengganti ini dengan logika database di masa depan
    $chartData = $this->getChartData(); 

    return view('home', compact('totalReports', 'pendingReports', 'closedReports', 'chartData'));
    }

    protected function getChartData()
{
    // Mengambil laporan tertunda paling mendesak (contoh: 5 laporan prioritas tertinggi)
    $urgentReports = Report::where('status', 'Pending')
                           ->orderByRaw("FIELD(priority, 'Tinggi', 'Sedang', 'Rendah')")
                           ->limit(5)
                           ->get();

    return [
        'urgentReports' => $urgentReports,
        // Chart.js data akan tetap menggunakan dummy, kecuali Anda ingin mengembangkannya
    ];
}

    public function create()
{
        // Ambil hanya data Lokasi, Jenis, dan Dampak yang akan ditampilkan
        $locations = MasterOption::where('category', 'lokasi')->where('is_active', 1)->get();
        $types = MasterOption::where('category', 'jenis')->where('is_active', 1)->get();
        $impacts = MasterOption::where('category', 'dampak')->where('is_active', 1)->get();
        
        // Prioritas dan Status tidak perlu diambil karena diset otomatis/disabled
        return view('reports.create', compact('locations', 'types', 'impacts'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'description' => 'required|string',
            'location' => 'required|string',
            'type' => 'required|string',
            'impact' => 'required|string',
            
            // Bidang Baru
            'incident_datetime' => 'nullable|date', // Diganti dari tanggalWaktu ke incident_datetime
            'involved_parties' => 'nullable|string|max:255', // Diganti dari pihakTerlibat ke involved_parties
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:20480', // Asumsi satu file upload
        ]);

        // Buat objek laporan baru
        $report = new Report;
        $report->description = $request->description;
        $report->location = $request->location;
        $report->type = $request->type;
        $report->impact = $request->impact;
        
        // Data Otomatis & Baru
        $report->incident_datetime = $request->incident_datetime; // Simpan waktu kejadian
        $report->involved_parties = $request->involved_parties; // Simpan pihak terlibat
        $report->reported_by = Auth::user()->name; 
        
        // Status dan Prioritas Awal (Sesuai Konsep Desain)
        $report->status = 'Pending'; // Set default Status
        $report->priority = 'Rendah'; // Set default Prioritas (akan diubah SPV)

    if ($request->hasFile('media')) {
        $file = $request->file('media');
        $fileName = $file->hashName(); // Nama file unik
        $folderPath = 'reports';      // Subfolder di dalam disk 'public'

        try {
            // Gunakan Storage Facade untuk penyimpanan yang lebih eksplisit
            // Menyimpan ke: storage/app/public/reports/
            $filePath = Storage::disk('public')->putFileAs($folderPath, $file, $fileName);

            // Jika penyimpanan berhasil, simpan path relatif di database: reports/namafile.png
            $report->media_path = $filePath; 

        } catch (\Exception $e) {
            // DEBUGGING: Tambahkan log jika penyimpanan gagal
            \Log::error('File upload failed: ' . $e->getMessage());
            // Anda mungkin ingin mengembalikan error ke user di sini
            return back()->withInput()->withErrors(['media' => 'Gagal mengunggah file. Cek izin folder.']);
        }
    }
    // END: LOGIKA PENYIMPANAN YANG EKSPLISIT

    // 3. SIMPAN OBJEK KE DATABASE
    $report->save();

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diajukan! Menunggu peninjauan Tim K3.');
    }

    public function edit($id)
    {
        $report = Report::findOrFail($id);
        $statuses = MasterOption::where('category', 'status')->where('is_active', 1)->get();
        $priorities = MasterOption::where('category', 'prioritas')->where('is_active', 1)->get();
        
        return view('reports.edit', compact('report', 'statuses', 'priorities'));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        
        $request->validate([
            'status' => 'required|string',
            'priority' => 'required|string',
        ]);

        $report->status = $request->status;
        $report->priority = $request->priority;
        $report->save();

        return redirect()->route('reports.index')->with('success', 'Status laporan berhasil diperbarui!');
    }

    public function show($id)
    {
        $report = Report::findOrFail($id);
        return view('reports.show', compact('report'));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report; // <-- Tambahkan ini
use App\Models\MasterOption; // <-- Tambahkan ini
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 1. Ambil Data Ringkasan
        $totalReports = Report::count();
        $pendingReports = Report::where('status', 'Pending')->count();
        $closedReports = Report::where('status', 'Closed')->count();

        // 2. Ambil Data Urgent Reports (untuk tabel)
        $urgentReports = Report::where('status', 'Pending')
                               ->orderByRaw("FIELD(priority, 'Tinggi', 'Sedang', 'Rendah')")
                               ->limit(5)
                               ->get();
        
        $chartData = [
            'urgentReports' => $urgentReports,
        ];

        // 3. Kirim semua variabel ke view 'home'
        return view('home', compact('totalReports', 'pendingReports', 'closedReports', 'chartData'));
    }
}

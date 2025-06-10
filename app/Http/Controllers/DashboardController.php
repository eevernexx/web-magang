<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 1) {
            // Admin Dashboard
            $totalMahasiswa = User::where('role_id', 2)
                                ->where('status', 'approved')
                                ->count();

            $today = now()->format('Y-m-d');
            
            $sudahMengumpulkan = Submission::whereDate('report_date', $today)
                                        ->distinct('user_id')
                                        ->count('user_id');
            
            $belumMengumpulkan = $totalMahasiswa - $sudahMengumpulkan;

            $statistikMingguan = Submission::select(DB::raw('DATE(report_date) as tanggal'), DB::raw('COUNT(DISTINCT user_id) as jumlah'))
                                        ->where('report_date', '>=', now()->subDays(7))
                                        ->groupBy('tanggal')
                                        ->orderBy('tanggal')
                                        ->get();

            return view('pages.dashboard', compact(
                'totalMahasiswa',
                'sudahMengumpulkan',
                'belumMengumpulkan',
                'statistikMingguan'
            ));
        } else {
            // User Dashboard
            $userId = Auth::id();
            $today = now()->format('Y-m-d');
            
            // Cek apakah user sudah mengumpulkan hari ini
            $sudahMengumpulkanHariIni = Submission::where('user_id', $userId)
                                                ->whereDate('report_date', $today)
                                                ->exists();

            // Total tugas yang sudah dikumpulkan
            $totalTugas = Submission::where('user_id', $userId)->count();

            // Statistik pengumpulan 7 hari terakhir
            $statistikUser = Submission::select(DB::raw('DATE(report_date) as tanggal'), DB::raw('COUNT(*) as jumlah'))
                                    ->where('user_id', $userId)
                                    ->where('report_date', '>=', now()->subDays(7))
                                    ->groupBy('tanggal')
                                    ->orderBy('tanggal')
                                    ->get();

            return view('pages.dashboard', compact(
                'sudahMengumpulkanHariIni',
                'totalTugas',
                'statistikUser'
            ));
        }
    }
} 
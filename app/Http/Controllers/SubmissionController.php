<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\SubmissionImage;
use App\Models\AnakMagang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SubmissionController extends Controller
{
    public function index()
    {
        $submission = Submission::with('images')->latest()->paginate(10);
        return view('pages.submission.index', compact('submission'));
    }

    public function create()
    {
        // Cek apakah user sudah terhubung dengan anak_magang
        $anakMagang = AnakMagang::where('user_id', Auth::id())->first();
        
        // Jika tidak ada data anak magang yang terkait
        if (!$anakMagang) {
            return redirect()->route('submission.index')
                ->with('error', 'Akun belum terhubung dengan data magang. Silakan kontak admin untuk menghubungkan akun Anda.');
        }
        
        return view('pages.submission.create');
    }

    public function store(Request $request)
    {
        // Cek apakah user sudah terhubung dengan anak_magang
        $anakMagang = AnakMagang::where('user_id', Auth::id())->first();
        
        // Jika tidak ada data anak magang yang terkait
        if (!$anakMagang) {
            return redirect()->route('submission.index')
                ->with('error', 'Akun belum terhubung dengan data magang. Silakan kontak admin untuk menghubungkan akun Anda.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:2048', // max 2MB per photo
            'photos' => 'required|array|min:3|max:5'
        ]);

        // Create submission
        $submission = Submission::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'status' => 'new',
            'is_valid' => false,
            'report_date' => Carbon::now(),
            'user_id' => Auth::id()
        ]);

        $uploadedCount = 0;
        // Save photos
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('foto_tugas', $filename, 'public');
                SubmissionImage::create([
                    'submission_id' => $submission->id,
                    'image_path' => 'foto_tugas/' . $filename
                ]);
                $uploadedCount++;
            }
        }

        // Set valid jika minimal 3 foto
        if ($uploadedCount >= 3) {
            $submission->is_valid = true;
            $submission->save();
        }

        return redirect()->route('submission.index')
            ->with('success', $uploadedCount >= 3 ? 'Tugas berhasil dibuat & valid (foto minimal 3)' : 'Tugas berhasil dibuat');
    }

    public function destroy($id)
    {
        $submission = Submission::with('images')->findOrFail($id);
        // Delete all photos
        foreach ($submission->images as $image) {
            Storage::delete('public/submissions/' . $image->image_path);
            $image->delete();
        }
        $submission->delete();

        return redirect()->route('submission.index')
            ->with('success', 'Tugas berhasil dihapus');
    }

    public function deleteImage(SubmissionImage $image)
    {
        if ($image->submission->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $filePath = 'public/submissions/' . $image->image_path;
        $fileDeleted = true;
        if (Storage::exists($filePath)) {
            $fileDeleted = Storage::delete($filePath);
        }
        $dbDeleted = $image->delete();

        if ($fileDeleted && $dbDeleted) {
            return response()->json(['success' => true]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus file atau data. File: ' . ($fileDeleted ? 'ok' : 'fail') . ', DB: ' . ($dbDeleted ? 'ok' : 'fail')
            ], 500);
        }
    }

    public function edit($id)
    {
        $submission = Submission::with('images')->findOrFail($id);
        // Pastikan hanya user yang berhak yang bisa edit
        if ($submission->user_id !== Auth::id()) {
            abort(403);
        }
        return view('pages.submission.edit', compact('submission'));
    }

    public function update(Request $request, $id)
    {
        $submission = Submission::with('images')->findOrFail($id);
        if ($submission->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048', // max 2MB per photo
            'photos' => 'array|max:5'
        ]);

        $submission->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        $uploadedCount = $submission->images()->count();
        // Upload foto baru jika ada
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs('foto_tugas', $filename, 'public');
                SubmissionImage::create([
                    'submission_id' => $submission->id,
                    'image_path' => 'foto_tugas/' . $filename
                ]);
                $uploadedCount++;
            }
        }

        // Set valid jika minimal 3 foto
        if ($uploadedCount >= 3) {
            $submission->is_valid = true;
            $submission->save();
        } else {
            $submission->is_valid = false;
            $submission->save();
        }

        return redirect()->route('submission.index')
            ->with('success', $uploadedCount >= 3 ? 'Tugas berhasil diupdate & valid (foto minimal 3)' : 'Tugas berhasil diupdate');
    }

    public function allSubmissions(Request $request)
    {
        // Ambil semua user dengan role_id = 2 (user biasa) yang sudah disetujui
        $users = User::where('role_id', 2)
                    ->where('status', 'approved')
                    ->get();

        // Tentukan tanggal yang akan ditampilkan
        $selectedDate = $request->date ? Carbon::parse($request->date)->format('Y-m-d') : now()->format('Y-m-d');

        // Ambil data submission untuk tanggal yang dipilih
        $submissions = Submission::whereDate('report_date', $selectedDate)
                                ->get()
                                ->groupBy('user_id');

        // Siapkan data untuk view
        $userData = $users->map(function($user) use ($submissions) {
            $submission = $submissions->get($user->id, collect())->first();
            
            return [
                'user' => $user,
                'submission' => $submission,
                'has_submitted' => !is_null($submission),
                'submission_time' => $submission ? $submission->created_at : null
            ];
        });

        // Urutkan data: yang sudah mengumpulkan di atas, yang belum di bawah
        $sortedUserData = $userData->sortByDesc('has_submitted')->values();

        return view('pages.admin.all-submissions', [
            'userData' => $sortedUserData,
            'selectedDate' => $selectedDate
        ]);
    }

    public function exportSubmissions(Request $request)
    {
        // Ambil semua user dengan role_id = 2 (user biasa) yang sudah disetujui
        $users = User::where('role_id', 2)
                    ->where('status', 'approved')
                    ->get();

        // Siapkan query untuk submissions
        $query = Submission::query();

        // Filter berdasarkan tanggal atau bulan
        if ($request->filter_type === 'date' && $request->date) {
            $query->whereDate('report_date', $request->date);
            $filterDate = $request->date;
        } elseif ($request->filter_type === 'month' && $request->month) {
            $date = \Carbon\Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('report_date', $date->year)
                  ->whereMonth('report_date', $date->month);
            $filterDate = $date->format('Y-m');
        } else {
            $filterDate = now()->format('Y-m-d');
            $query->whereDate('report_date', $filterDate);
        }

        // Dapatkan submissions yang sudah mengumpulkan
        $submissions = $query->get()->groupBy('user_id');

        // Siapkan data untuk ekspor
        $exportData = [];
        $submittedData = [];
        $notSubmittedData = [];
        
        foreach ($users as $user) {
            $hasSubmitted = $submissions->has($user->id);
            $submission = $hasSubmitted ? $submissions[$user->id]->first() : null;

            // Filter berdasarkan status pengumpulan
            if ($request->submission_status === 'submitted' && !$hasSubmitted) {
                continue;
            }
            if ($request->submission_status === 'not_submitted' && $hasSubmitted) {
                continue;
            }

            $rowData = [
                'Tanggal' => $request->filter_type === 'month' ? $filterDate : Carbon::parse($filterDate)->format('Y-m-d'),
                'Nama' => $user->name,
                'Email' => $user->email,
                'Universitas' => $user->university,
                'Status Pengumpulan' => $hasSubmitted ? 'Sudah Mengumpulkan' : 'Belum Mengumpulkan',
                'Judul Tugas' => $hasSubmitted ? $submission->title : '-',
            ];

            // Pisahkan data berdasarkan status pengumpulan
            if ($hasSubmitted) {
                $submittedData[] = $rowData;
            } else {
                $notSubmittedData[] = $rowData;
            }
        }

        // Gabungkan data dengan yang sudah mengumpulkan di atas
        $exportData = array_merge($submittedData, $notSubmittedData);

        if ($request->format === 'excel') {
            $filename = 'laporan_tugas_' . now()->format('Y-m-d_H-i-s') . '.csv';
            
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            $output = fopen('php://output', 'w');
            
            // Add BOM for Excel to properly display UTF-8
            fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Add headers
            if (!empty($exportData)) {
                fputcsv($output, array_keys($exportData[0]));
            }
            
            // Add data rows
            foreach ($exportData as $row) {
                fputcsv($output, $row);
            }
            
            fclose($output);
            exit;
        } else {
            $pdf = PDF::loadView('exports.submissions-pdf', ['submissions' => $exportData]);
            return $pdf->download('laporan_tugas_' . now()->format('Y-m-d_H-i-s') . '.pdf');
        }
    }
}

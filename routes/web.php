<?php

use App\Http\Controllers\AnakMagangController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get("/", [AuthController::class,'login'])->name('login');
Route::get("/new-account", [AuthController::class,'registerView']);
Route::post("/login", [AuthController::class,'authenticate']);
Route::post("/logout", [AuthController::class,'logout']);
Route::post("/register", [AuthController::class,'register']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('role:admin,user');

//Admin - Data Anak Magang
Route::get('/anak_magangs', [AnakMagangController::class, 'index'])
    ->name('anak_magangs.index')
    ->middleware('role:admin');

Route::get('/anak_magangs/create', [AnakMagangController::class, 'create'])
    ->name('anak_magangs.create')
    ->middleware('role:admin');

Route::post('/anak_magangs', [AnakMagangController::class, 'store'])
    ->name('anak_magangs.store')
    ->middleware('role:admin');

Route::get('/anak_magangs/{id}/edit', [AnakMagangController::class, 'edit'])
    ->name('anak_magangs.edit')
    ->middleware('role:admin');

Route::put('/anak_magangs/{id}', [AnakMagangController::class, 'update'])
    ->name('anak_magangs.update')
    ->middleware('role:admin');

Route::delete('/anak_magangs/{id}', [AnakMagangController::class, 'destroy'])
    ->name('anak_magangs.destroy')
    ->middleware('role:admin');


//Admin - Daftar Akun
Route::get('/account-list',[UserController::class,'account_list_view'])->middleware('role:admin');
Route::put('/account/{id}', [UserController::class, 'update'])->name('account.update')->middleware('role:admin');
Route::delete('/account/{id}', [UserController::class, 'destroy'])->name('account.destroy')->middleware('role:admin');

//Admin - Permintaan Akun
Route::get('/account-request', [UserController::class,'account_request_view'])->middleware('role:admin');
Route::post('/account-request/approval/{id}', [UserController::class,'account_approval'])->middleware('role:admin');

Route::get('/profile', [UserController::class,'profile_view'])->middleware('role:admin,user');
Route::post('/profile/{id}', [UserController::class,'update_profile'])->middleware('role:admin,user');
Route::get('/change-password', [UserController::class,'change_password_view'])->middleware('role:admin,user');
Route::post('/change-password/{id}', [UserController::class,'change_password'])->middleware('role:admin,user');

//User - Pengumpulan Tugas
Route::get('/submission', [SubmissionController::class, 'index'])
    ->name('submission.index')
    ->middleware('role:admin,user');

Route::get('/submission/create', [SubmissionController::class, 'create'])
    ->name('submission.create')
    ->middleware('role:user');

Route::post('/submission', [SubmissionController::class, 'store'])
    ->name('submission.store')
    ->middleware('role:user');

Route::get('/submission/{id}/edit', [SubmissionController::class, 'edit'])
    ->name('submission.edit')
    ->middleware('role:user');

Route::put('/submission/{id}', [SubmissionController::class, 'update'])
    ->name('submission.update')
    ->middleware('role:user');

Route::delete('/submission/{id}', [SubmissionController::class, 'destroy'])
    ->name('submission.destroy')
    ->middleware('role:user');

Route::delete('/submission/image/{image}', [SubmissionController::class, 'deleteImage'])->name('submission.image.delete');

// Serve submission images
Route::get('/img/submissions/{filename}', function ($filename) {
    $path = storage_path('app/public/submissions/' . $filename);
    if (!file_exists($path)) abort(404);
    return response()->file($path);
});

// Serve profile pictures
Route::get('/img/profile/{filename}', function ($filename) {
    $path = storage_path('app/public/profile_pictures/' . $filename);
    if (!file_exists($path)) abort(404);
    return response()->file($path);
});

// Serve surat validasi
Route::get('/file/surat/{filename}', function ($filename) {
    $path = storage_path('app/public/surat_validasi/' . $filename);
    if (!file_exists($path)) abort(404);
    return response()->file($path);
});

// Admin - Lihat semua tugas
Route::get('/admin/all-submissions', [App\Http\Controllers\SubmissionController::class, 'allSubmissions'])
    ->name('admin.all-submissions')
    ->middleware('role:admin');

// Admin - Ekspor tugas berdasarkan hari/bulan
Route::get('/admin/export-submissions', [App\Http\Controllers\SubmissionController::class, 'exportSubmissions'])
    ->name('admin.export-submissions')
    ->middleware('role:admin');

// Serve foto tugas
Route::get('/storage/foto_tugas/{filename}', function ($filename) {
    $path = storage_path('app/public/foto_tugas/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path);
})->name('foto.tugas');
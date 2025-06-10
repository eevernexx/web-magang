@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Status Pengumpulan Tugas</h1>
    </div>

    <!-- Filter Tanggal -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('admin.all-submissions') }}" method="GET" class="row align-items-end">
                <div class="col-md-4">
                    <label for="date" class="form-label">Pilih Tanggal</label>
                    <div class="input-group">
                        <input type="date" class="form-control" id="date" name="date" 
                               value="{{ $selectedDate }}" max="{{ date('Y-m-d') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Tampilkan
                        </button>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.all-submissions') }}" class="btn btn-secondary">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Data Pengumpulan Tanggal: {{ \Carbon\Carbon::parse($selectedDate)->locale('id')->isoFormat('LL') }}
            </h6>
            <!-- Export Button -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-download fa-sm text-white-50"></i> Ekspor Data
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 300px;">
                    <form action="{{ route('admin.export-submissions') }}" method="GET">
                        <input type="hidden" name="date" value="{{ $selectedDate }}">
                        <div class="mb-3">
                            <label class="form-label">Status Pengumpulan:</label>
                            <select class="form-select" name="submission_status">
                                <option value="all">Semua Status</option>
                                <option value="submitted">Sudah Mengumpulkan</option>
                                <option value="not_submitted">Belum Mengumpulkan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Format Ekspor:</label>
                            <select class="form-select" name="format">
                                <option value="excel">Excel</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Ekspor</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(count($userData) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="submissionTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Universitas</th>
                                <th>Status Pengumpulan</th>
                                <th>Detail Tugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userData as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data['user']->name }}</td>
                                    <td>{{ $data['user']->email }}</td>
                                    <td>{{ $data['user']->university }}</td>
                                    <td class="text-center">
                                        @if($data['has_submitted'])
                                            <span class="badge bg-success">Sudah Mengumpulkan</span>
                                        @else
                                            <span class="badge bg-danger">Belum Mengumpulkan</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($data['has_submitted'])
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $data['user']->id }}">
                                                <i class="fas fa-eye"></i> Lihat
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>

                                @if($data['has_submitted'])
                                    <!-- Modal Detail Tugas -->
                                    <div class="modal fade" id="detailModal{{ $data['user']->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Tugas - {{ $data['user']->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <h6>Judul:</h6>
                                                        <p>{{ $data['submission']->title }}</p>
                                                    </div>
                                                    <div class="mb-3">
                                                        <h6>Deskripsi:</h6>
                                                        <p>{{ $data['submission']->content }}</p>
                                                    </div>
                                                    <div>
                                                        <h6>Foto:</h6>
                                                        <div class="row">
                                                            @foreach($data['submission']->images as $image)
                                                                <div class="col-md-4 mb-3">
                                                                    <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank">
                                                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                                             alt="Foto Tugas" 
                                                                             class="img-fluid rounded"
                                                                             style="width: 100%; height: 200px; object-fit: cover;">
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-exclamation-circle fa-3x text-gray-300"></i>
                    </div>
                    <h5 class="text-gray-500 mb-0">Tidak ada data</h5>
                </div>
            @endif
        </div>
    </div>
</div>

@section('styles')
<style>
    .badge {
        font-size: 12px;
        padding: 6px 10px;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    #date {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    .input-group .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .btn-close {
        background: none;
        padding: 0.5rem;
        opacity: 0.5;
        transition: opacity 0.2s;
        border: none;
    }
    .btn-close:hover {
        opacity: 1;
    }
    .btn-close i {
        font-size: 1.2rem;
        color: #000;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#submissionTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
            }
        });
    });
</script>
@endsection

@endsection 
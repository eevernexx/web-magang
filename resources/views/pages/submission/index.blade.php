@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Berhasil",
                text: "{{ session()->get('success') }}",
                icon: "success",
                timer: 1800,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: "Gagal!",
                text: "{{ session()->get('error') }}",
                icon: "error"
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                title: "Terjadi kesalahan",
                text: "@foreach ($errors->all() as $error) {{ $error }} {{ $loop->last ? '' : ', ' }} @endforeach",
                icon: "error"
            });
        </script>
    @endif

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center gap-3">
            <h1>Pengumpulan Tugas</h1>
        </div>
        @php
            $anakMagang = \App\Models\AnakMagang::where('user_id', auth()->id())->first();
        @endphp
        @if(!$anakMagang)
            <div class="alert alert-warning mb-4" role="alert">
                <strong>Akun Anda belum terhubung dengan data magang.</strong> Silakan hubungi admin untuk menghubungkan akun Anda.
            </div>
        @elseif($anakMagang)
            <a href="/submission/create" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Buat Tugas
            </a>
        @else
            <button class="btn btn-sm btn-secondary shadow-sm" disabled title="Akun belum terhubung dengan data magang">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Buat Tugas
            </button>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    @if(count($submission) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="submissionTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul Tugas</th>
                                        <th>Deskripsi</th>
                                        <th>Foto</th>
                                        <th>Status</th>
                                        <th>Tanggal Upload</th>
                                        <th>Valid</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($submission as $index)
                                        @if ($index->user_id == auth()->id())
                                            <tr>
                                                <td>{{ $loop->iteration + $submission->firstItem() - 1 }}</td>
                                                <td>{{ $index->title }}</td>
                                                <td>{{ Str::limit($index->content, 50) }}</td>
                                                <td>
                                                    <div class="row g-2">
                                                        @foreach($index->images as $image)
                                                            <div class="col-auto">
                                                                <a href="{{ url('/storage/foto_tugas/' . basename($image->image_path)) }}" target="_blank">
                                                                    <img src="{{ url('/storage/foto_tugas/' . basename($image->image_path)) }}" 
                                                                         alt="Foto Tugas" 
                                                                         class="img-fluid rounded"
                                                                         style="width: 100px; height: 100px; object-fit: cover;">
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($index->status == 'new')
                                                        <span class="badge bg-primary">Baru</span>
                                                    @elseif($index->status == 'processing')
                                                        <span class="badge bg-warning">Diproses</span>
                                                    @elseif($index->status == 'completed')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @endif
                                                </td>
                                                <td>{{ $index->report_date->format('d/m/Y') }}</td>
                                                <td>
                                                    @if ($index->is_valid)
                                                        <span class="badge bg-success">Valid</span>
                                                    @else
                                                        <span class="badge bg-secondary">Belum</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="/submission/{{ $index->id }}/edit" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmationDelete{{ $index->id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @include('pages.submission.confirmation-delete')
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-tasks fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-500 mb-0">Belum ada pengumpulan tugas</h5>
                            <p class="text-gray-500">Klik tombol "Buat Tugas" untuk mengumpulkan tugas baru</p>
                        </div>
                    @endif
                </div>
                @if ($submission->lastPage() > 1)
                    <div class="card-footer">
                        {{ $submission->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

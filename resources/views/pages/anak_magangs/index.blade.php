@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Anak Magang</h1>
            <a href="{{ url('/anak_magangs/create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Anak Magang
            </a>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Akun</h6>
                    </div>
                    <div class="card-body">
                        @if(count($data) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Universitas</th>
                                            <th>Jurusan</th>
                                            <th>Bidang</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $index => $magang)
                                            <tr>
                                                <td>{{ $loop->iteration + $data->firstItem() - 1 }}</td>
                                                <td>{{ $magang->name }}</td>
                                                <td>{{ $magang->email }}</td>
                                                <td>{{ $magang->asal_sekolah }}</td>
                                                <td>{{ $magang->jurusan }}</td>
                                                <td>{{ $magang->bidang }}</td>
                                                <td>{{ $magang->tanggal_masuk }}</td>
                                                <td>{{ $magang->tanggal_keluar }}</td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center" style="gap: 10px;">
                                                        <a href="{{ url('/anak_magangs/' . $magang->id . '/edit') }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete{{ $magang->id }}">
                                                            <i class="fas fa-eraser"></i>
                                                        </button>
                                                        @if (!is_null($magang->user_id))
                                                        <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailAccount{{ $magang->id }}">
                                                            Lihat Akun
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @include('pages.anak_magangs.confirmation-delete')
                                            @if(!is_null($magang->user_id))
                                                @include('pages.anak_magangs.detail-account')
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($data->lastPage() > 1)
                                <div class="mt-3">
                                    {{ $data->links('pagination::bootstrap-5') }}
                                </div>
                            @endif
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
        </div>
    </div>
@endsection

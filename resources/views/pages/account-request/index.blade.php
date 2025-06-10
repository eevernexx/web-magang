@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Permintaan Akun</h1>
        </div>

        @if (session('success'))
            <script>
                Swal.fire({
                    title: "Berhasil",
                    text: "{{ session()->get('success') }}",
                    icon: "success"
                });
            </script>
        @endif

        <!-- Content Row -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        {{-- Cek jika ada data --}}
                        @if(count($users) > 0)
                            <div class="table-responsive">
                                <table id="userTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Universitas</th>
                                            <th>Jurusan</th>
                                            <th>Bidang</th>
                                            <th class="text-center" style="width: 100px;">Surat</th>
                                            <th class="text-center" style="width: 150px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Loop menggunakan $users --}}
                                        @foreach ($users as $item)
                                            <tr>
                                                <td>{{ $loop->iteration +$users->firstItem() - 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->university }}</td>
                                                <td>{{ $item->field_of_study }}</td>
                                                <td>{{ $item->bidang }}</td>
                                                <td class="text-center">
                                                    @if($item->surat_validasi)
                                                        <a href="{{ url('/file/surat/' . basename($item->surat_validasi)) }}" target="_blank" class="btn btn-sm btn-info">
                                                            <i class="fas fa-file-alt"></i> Lihat
                                                        </a>
                                                    @else
                                                        <span class="badge badge-warning">Tidak ada</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" style="gap: 10px;" role="group">
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationReject{{ $item->id }}">
                                                            Tolak
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#confirmationApprove{{ $item->id }}">
                                                            Setuju
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @include('pages.account-request.confirmation-approve')
                                            @include('pages.account-request.confirmation-reject')
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-exclamation-circle fa-3x text-gray-300"></i>
                                </div>
                                <h5 class="text-gray-500 mb-0">Tidak ada data akun yang perlu disetujui.</h5>
                            </div>
                        @endif
                    </div>
                    @if ($users->lastPage() > 1)
                    <div class="card-footer">
                        {{  $users -> links('pagination::bootstrap-5')}}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables Activation Script -->
    <script>
        $(document).ready(function () {
            if ($('#userTable').length) {
                $('#userTable').DataTable({
                    responsive: true,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data tersedia",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Berikutnya",
                            previous: "Sebelumnya"
                        }
                    }
                });
            }
        });
    </script>
@endsection

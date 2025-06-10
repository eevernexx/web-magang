@extends('layouts.app')

@section('content')
    <style>
        .btn-close {
            background: none;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            opacity: 0.5;
            transition: opacity 0.2s;
        }
        
        .btn-close:hover {
            opacity: 1;
        }
        
        .btn-close i {
            font-size: 1.2rem;
            color: #000;
        }
    </style>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Daftar Akun</h1>
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
                    <div class="card-header py-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-weight-bold text-primary">Data Akun</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari nama anak magang...">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="clearSearch">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($users) > 0)
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
                                            <th>Foto</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableData">
                                        @include('pages.account-list.table-data')
                                    </tbody>
                                </table>
                            </div>
                            <div id="pagination">
                                {{ $users->links('pagination::bootstrap-5') }}
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
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <style>
        .input-group-text {
            border: none;
        }
        #searchName {
            border-right: none;
        }
        .badge {
            font-size: 12px;
            padding: 5px 10px;
        }
        .dataTables_filter {
            display: none;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            let typingTimer;
            const doneTypingInterval = 500;
            
            // Fungsi untuk melakukan pencarian
            function performSearch() {
                const searchTerm = $('#searchInput').val();
                
                $.ajax({
                    url: '{{ url("/account-list") }}',
                    type: 'GET',
                    data: {
                        search: searchTerm
                    },
                    success: function(response) {
                        $('#tableData').html(response.table_data);
                        $('#pagination').html(response.pagination);
                    }
                });
            }
            
            // Event ketika user mengetik
            $('#searchInput').on('keyup', function() {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(performSearch, doneTypingInterval);
            });
            
            // Event ketika user mengklik tombol clear
            $('#clearSearch').on('click', function() {
                $('#searchInput').val('');
                performSearch();
            });
        });
    </script>
@endsection

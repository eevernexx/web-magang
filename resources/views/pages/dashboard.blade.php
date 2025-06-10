@extends('layouts.app')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        @if(auth()->user()->role_id == 1)
            <!-- Admin Dashboard -->
            <!-- Content Row -->
            <div class="row">
                <!-- Total Mahasiswa Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Mahasiswa Terdaftar</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMahasiswa }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sudah Mengumpulkan Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Sudah Mengumpulkan (Hari Ini)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudahMengumpulkan }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Belum Mengumpulkan Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Belum Mengumpulkan (Hari Ini)</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $belumMengumpulkan }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Mingguan -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Statistik Pengumpulan 7 Hari Terakhir</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="statistikMingguan"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- User Dashboard -->
            <!-- Content Row -->
            <div class="row">
                <!-- Panduan Pengumpulan Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="card-title font-weight-bold text-info text-uppercase mb-3">
                                Panduan Pengumpulan
                            </div>
                            <ul class="pl-4">
                                <li>Upload maksimal 5 file</li>
                                <li>Format: PDF, DOCX, JPG, PNG, ZIP</li>
                                <li>Ukuran maksimal 5MB per file</li>
                                <li>Pastikan file terupload dengan benar</li>
                                <li>Deadline pengumpulan pukul 17.00 WIB</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Status Hari Ini Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-{{ $sudahMengumpulkanHariIni ? 'success' : 'warning' }} shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-{{ $sudahMengumpulkanHariIni ? 'success' : 'warning' }} text-uppercase mb-1">
                                        Status Hari Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $sudahMengumpulkanHariIni ? 'Sudah Mengumpulkan' : 'Belum Mengumpulkan' }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-{{ $sudahMengumpulkanHariIni ? 'check' : 'exclamation' }}-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Tugas Card -->
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Tugas Dikumpulkan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTugas }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik User -->
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengumpulan 7 Hari Terakhir</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="statistikUser"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @if(auth()->user()->role_id == 1)
            // Data untuk grafik admin
            const statistikData = @json($statistikMingguan);
            
            // Siapkan data untuk Chart.js
            const labels = statistikData.map(item => {
                const date = new Date(item.tanggal);
                return date.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short' });
            });
            const data = statistikData.map(item => item.jumlah);

            // Buat grafik admin
            const ctx = document.getElementById('statistikMingguan').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Mahasiswa Mengumpulkan',
                        data: data,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        @else
            // Data untuk grafik user
            const statistikUser = @json($statistikUser);
            
            // Siapkan data untuk Chart.js
            const labelsUser = statistikUser.map(item => {
                const date = new Date(item.tanggal);
                return date.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short' });
            });
            const dataUser = statistikUser.map(item => item.jumlah);

            // Buat grafik user
            const ctxUser = document.getElementById('statistikUser').getContext('2d');
            new Chart(ctxUser, {
                type: 'bar',
                data: {
                    labels: labelsUser,
                    datasets: [{
                        label: 'Jumlah Tugas Dikumpulkan',
                        data: dataUser,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        @endif
    </script>
@endsection

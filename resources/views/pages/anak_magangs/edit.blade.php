@extends('layouts.app')

@section('content')
        <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Anak Magang</h1>
    </div>

    @if ($errors -> any())
        @dd($errors -> all())
    @endif

    <div class="row">
        <div class="col">
            <form action="/anak_magangs/{{ $item ->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method ('PUT')
                <div class="card">
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="asal_sekolah">Asal Sekolah</label>
                            <input type="text" name="asal_sekolah" id="asal_sekolah" class="form-control" value="{{ old('asal_sekolah', $item-> asal_sekolah) }}" required>
                        </div>

                        <!-- Bidang -->
                        <div class="form-group">
                            <select name="bidang" class="form-control form-control-user" id="inputBidang" placeholder="Pilih Bidang">
                                <option value="" disabled selected>Pilih Bidang</option>
                                <option value="Pengembangan Komunikasi Publik">Pengembangan Komunikasi Publik</option>
                                <option value="Sistem Pemerintahan Berbasis Elektronik">Sistem Pemerintahan Berbasis Elektronik</option>
                                <option value="Pengelolaan Informasi Dan Saluran Komunikasi Publik">Pengelolaan Informasi Dan Saluran Komunikasi Publik</option>
                                <option value="Pengelolaan Infrastruktur">Pengelolaan Infrastruktur</option>
                                <option value="Statistik">Statistik</option>
                                <option value="Sekretariat">Sekretariat</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jurusan">Jurusan</label>
                            <input type="text" name="jurusan" id="jurusan" class="form-control" value="{{ old('jurusan', $item -> jurusan) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $item -> tanggal_masuk) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="tanggal_keluar">Tanggal Keluar</label>
                            <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="form-control" value="{{ old('tanggal_keluar', $item -> tanggal_keluar) }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                            <a href="{{ url('/anak_magangs') }}" class="btn btn-secondary">Kembali</a>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

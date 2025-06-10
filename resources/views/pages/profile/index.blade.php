@extends('layouts.app')

@section('content')
<div class="container mt-5">
        @if (session('success'))
            <script>
                Swal.fire({
                    title: "Berhasil",
                    text: "{{ session()->get('success') }}",
                    icon: "success"
                });
            </script>
        @endif
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-2">Edit Profil</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="/profile/{{ auth()->user()->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', auth()->user()->email) }}" readonly>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="university" class="form-label">Asal Sekolah / Universitas</label>
                            <input type="text" name="university" class="form-control @error('university') is-invalid @enderror"
                                value="{{ old('university', auth()->user()->university) }}">
                            @error('university')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="field_of_study" class="form-label">Jurusan</label>
                            <input type="text" name="field_of_study" class="form-control @error('field_of_study') is-invalid @enderror"
                                value="{{ old('field_of_study', auth()->user()->field_of_study) }}">
                            @error('field_of_study')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Foto Profil</label><br>

                            @if(auth()->user()->profile_picture)
                                <img src="{{ url('/img/profile/' . basename(auth()->user()->profile_picture)) }}" alt="Foto Profil" class="mb-3 rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <img src="{{ asset('template/img/default-profile.png') }}" alt="Default Foto" class="mb-3 rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                            @endif

                            <div class="custom-file">
                                <input type="file" name="profile_picture" id="profile_picture" class="d-none" onchange="previewFile()">
                                <label for="profile_picture" class="btn btn-outline-secondary">Pilih Foto Baru</label>
                            </div>

                            @error('profile_picture')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
                            <a href="{{ url('/dashboard') }}" class="btn btn-outline-secondary">Kembali</a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

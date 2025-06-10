@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <script>
            Swal.fire({
                title: "Terjadi kesalahan",
                text: "@foreach ($errors->all() as $error) {{ $error }} {{ $loop->last ? '' : ', ' }} @endforeach",
                icon: "error"
            });
        </script>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Buat Tugas Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('submission.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Tugas</label>
                            <input type="text" class="form-control" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Deskripsi Tugas</label>
                            <textarea class="form-control" 
                                      id="content" name="content" rows="4" required>{{ old('content') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="photos" class="form-label">Foto Tugas (Minimal 3, Maksimal 5)</label>
                            <input type="file" class="form-control" 
                                   id="photos" name="photos[]" multiple accept="image/*" required>
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB per foto</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('submission.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Buat Tugas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

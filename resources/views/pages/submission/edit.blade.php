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
                    <h4 class="mb-0">Edit Tugas</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('submission.update', $submission->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Tugas</label>
                            <input type="text" class="form-control" 
                                   id="title" name="title" value="{{ old('title', $submission->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Deskripsi Tugas</label>
                            <textarea class="form-control" 
                                      id="content" name="content" rows="4" required>{{ old('content', $submission->content) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Tugas Saat Ini</label>
                            <div class="d-flex gap-2 mb-2 flex-wrap">
                                @foreach($submission->images as $image)
                                    <div class="position-relative" style="display:inline-block;">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             alt="Foto Tugas" 
                                             class="img-thumbnail" 
                                             style="width: 100px; height: 100px; object-fit: cover;">
                                        <button type="button" 
                                                class="btn btn-danger btn-sm position-absolute" 
                                                style="top:2px; right:2px; z-index:2; padding:2px 6px; border-radius:50%;"
                                                onclick="deleteImage({{ $image->id }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="photos" class="form-label">Tambah Foto Baru (Opsional)</label>
                            <input type="file" class="form-control" 
                                   id="photos" name="photos[]" multiple accept="image/*">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB per foto</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('submission.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update Tugas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteImage(imageId) {
    console.log('Menghapus image id:', imageId);
    Swal.fire({
        title: 'Hapus Foto?',
        text: 'Apakah Anda yakin ingin menghapus foto ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/submission/image/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json().then(data => ({status: response.status, body: data})))
            .then(res => {
                console.log('Response hapus:', res);
                if (res.status === 200 && res.body.success) {
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Foto berhasil dihapus!',
                        icon: 'success',
                        timer: 1200,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1200);
                } else {
                    Swal.fire({
                        title: 'Gagal menghapus foto',
                        text: res.body.message || 'Terjadi kesalahan saat menghapus foto',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Gagal menghapus foto',
                    text: 'Terjadi kesalahan saat menghapus foto',
                    icon: 'error'
                });
            });
        }
    });
}
</script>
@endsection

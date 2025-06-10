<div class="modal fade" id="detailAccount{{ $magang->id }}" tabindex="-1" aria-labelledby="detailAccountLabel" aria-hidden="true">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailAccountLabel">Detail Akun</h1>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                @if($magang->user)
                <div class="form-group mb-3">
                    <label for="name">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ $magang->user->name }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $magang->user->email }}" readonly>
                </div>
                @else
                <div class="alert alert-warning">
                    Tidak ada data akun yang terkait
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div> 
  </div>
</div>
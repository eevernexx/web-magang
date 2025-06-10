<div class="modal fade" id="confirmationDelete{{ $magang->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/anak_magangs/{{ $magang -> id }}" method="post">
    @csrf
    @method('DELETE')
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <span>Apakah anda yakin akan menghapus data ini?</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-outline-danger">Ya, Hapus!</button>
            </div>
        </div> 
    </form>
  </div>
</div>
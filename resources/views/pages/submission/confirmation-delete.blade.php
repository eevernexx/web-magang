<!-- Modal Konfirmasi Hapus Submission -->
<div class="modal fade" id="confirmationDelete{{ $index->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $index->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="/submission/{{ $index->id }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel{{ $index->id }}">Konfirmasi Hapus</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus tugas <b>{{ $index->title }}</b>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>
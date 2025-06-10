<div class="modal fade" id="confirmationApprove{{ $item->id }}" tabindex="-1" aria-labelledby="comfirmationApprovelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/account-request/approval/{{ $item -> id }}" method="post">
    @csrf
    @method('POST')
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="comfirmationApprovelLabel">Konfirmasi Setujui</h1>
                <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="for" value="approve">

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Apakah Anda yakin akan menyetujui pendaftaran akun <strong>{{ $item->name }}</strong>?
                    <br>
                    <small class="text-muted">User akan langsung dapat mengakses dan mengumpulkan tugas setelah disetujui.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">Ya, Setujui!</button>
            </div>
        </div>
    </form>
  </div>
</div>
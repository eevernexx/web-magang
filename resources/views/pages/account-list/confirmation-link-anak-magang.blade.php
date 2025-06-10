<div class="modal fade" id="confirmationLinkAnakMagang{{ $user->id }}" tabindex="-1" aria-labelledby="confirmationLinkAnakMagangLabel{{ $user->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form action="/account-request/approval/{{ $user->id }}" method="POST">
      @csrf
      <input type="hidden" name="for" value="approve">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title" id="confirmationLinkAnakMagangLabel{{ $user->id }}">Konfirmasi Kaitkan Data Magang</h1>
          <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <span>Apakah Anda yakin ingin mengaitkan akun <b>{{ $user->name }}</b> dengan data magang secara otomatis?</span>
          <div class="form-group mt-3">
            <label for="anak_magangs_id">Pilih Data Magang</label>
            <select name="anak_magangs_id" id="anak_magangs_id" class="form-control">
              <option value="">Tidak Ada</option>
              @foreach ($anak_magangs as $anak)
                <option value="{{ $anak->id }}">{{ $anak->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-outline-warning">Ya, Kaitkan!</button>
        </div>
      </div>
    </form>
  </div>
</div> 
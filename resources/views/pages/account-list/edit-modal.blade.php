<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('account.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control bg-light" id="email" name="email" value="{{ $item->email }}" readonly>
                        <small class="text-muted">Email tidak dapat diubah</small>
                    </div>
                    <div class="mb-3">
                        <label for="university" class="form-label">Universitas</label>
                        <input type="text" class="form-control" id="university" name="university" value="{{ $item->university }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="field_of_study" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="field_of_study" name="field_of_study" value="{{ $item->field_of_study }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="bidang" class="form-label">Bidang</label>
                        <select class="form-control" id="bidang" name="bidang" required>
                            <option value="" disabled>Pilih Bidang</option>
                            <option value="Pengembangan Komunikasi Publik" {{ $item->bidang == 'Pengembangan Komunikasi Publik' ? 'selected' : '' }}>Pengembangan Komunikasi Publik</option>
                            <option value="Sistem Pemerintahan Berbasis Elektronik" {{ $item->bidang == 'Sistem Pemerintahan Berbasis Elektronik' ? 'selected' : '' }}>Sistem Pemerintahan Berbasis Elektronik</option>
                            <option value="Pengelolaan Informasi Dan Saluran Komunikasi Publik" {{ $item->bidang == 'Pengelolaan Informasi Dan Saluran Komunikasi Publik' ? 'selected' : '' }}>Pengelolaan Informasi Dan Saluran Komunikasi Publik</option>
                            <option value="Pengelolaan Infrastruktur" {{ $item->bidang == 'Pengelolaan Infrastruktur' ? 'selected' : '' }}>Pengelolaan Infrastruktur</option>
                            <option value="Statistik" {{ $item->bidang == 'Statistik' ? 'selected' : '' }}>Statistik</option>
                            <option value="Sekretariat" {{ $item->bidang == 'Sekretariat' ? 'selected' : '' }}>Sekretariat</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div> 
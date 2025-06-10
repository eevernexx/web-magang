@forelse ($data as $index => $magang)
    <tr>
        <td>{{ $loop->iteration + $data->firstItem() - 1 }}</td>
        <td>{{ $magang->name }}</td>
        <td>{{ $magang->email }}</td>
        <td>{{ $magang->asal_sekolah }}</td>
        <td>{{ $magang->jurusan }}</td>
        <td>{{ $magang->bidang }}</td>
        <td>{{ $magang->tanggal_masuk }}</td>
        <td>{{ $magang->tanggal_keluar }}</td>
        <td class="text-center">
            <div class="d-flex justify-content-center" style="gap: 10px;">
                <a href="{{ url('/anak_magangs/' . $magang->id . '/edit') }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                </a>
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationDelete{{ $magang->id }}">
                    <i class="fas fa-eraser"></i>
                </button>
                @if (!is_null($magang->user_id))
                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailAccount{{ $magang->id }}">
                    Lihat Akun
                </button>
                @endif
            </div>
        </td>
    </tr>
    @include('pages.anak_magangs.confirmation-delete')
    @if(!is_null($magang->user_id))
        @include('pages.anak_magangs.detail-account')
    @endif
@empty
    <tr>
        <td colspan="9" class="text-center py-3">
            <div class="text-gray-500">Data tidak ditemukan</div>
        </td>
    </tr>
@endforelse 
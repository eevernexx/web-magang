@foreach ($users as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->email }}</td>
        <td>{{ $item->university ?? '-' }}</td>
        <td>{{ $item->field_of_study ?? '-' }}</td>
        <td>{{ $item->bidang ?? '-' }}</td>
        <td class="text-center">
            @if ($item->profile_picture)
                <img src="{{ url('/img/profile/' . basename($item->profile_picture)) }}" width="80" height="80" class="rounded-circle" style="object-fit: cover;">
            @else
                <img src="{{ asset('template/img/default-profile.png') }}" width="80" height="80" class="rounded-circle" style="object-fit: cover;">
            @endif
        </td>
        <td class="text-center">
            @if($item->status == 'approved')
                <span class="badge badge-success">Aktif</span>
            @else
                <span class="badge badge-danger">Tidak Aktif</span>
            @endif
        </td>
        <td class="text-center">
            <div class="d-flex justify-content-center" style="gap: 5px;">
                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </td>
    </tr>
    @include('pages.account-list.edit-modal')
    @include('pages.account-list.delete-modal')
@endforeach 
@extends('layouts.backend')

@section('backend_content')
    <style>
        .action-links {
            display: flex;
            flex-direction: row;
        }

        .action-links a {
            margin-right: 10px;
        }
    </style>

    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Tabel {{ $title }}</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <a href="/partner/create" class="text-decoration-none btn btn-outline-dark mb-3"><i
                                class="ti ti-plus me-1"></i>Tambah {{ $title }}</a>

                        <table id="product" class="table" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Actions</th>
                                    <th>User</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Jenis Usaha</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="action-links">
                                            <a href="{{ route('partner.edit', $item->id) }}"
                                                class="text-decoration-none btn btn-outline-dark mb-3">Ubah</a>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-dark dropdown-toggle" type="button"
                                                    id="moreActionsDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    More
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="moreActionsDropdown">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('partner.show', $item->id) }}"><i
                                                                class="ti ti-info-circle me-1 text-black"></i>Detail</a>
                                                    </li>
                                                    <form id="formDelete" method="post"
                                                        action="{{ route('partner.destroy', $item->id) }}">
                                                        @method('delete')
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <li><button class="dropdown-item deleteButton"><i
                                                                    class="ti ti-trash text-black me-1"
                                                                    onclick="confirm?"></i>Hapus</button>
                                                        </li>
                                                    </form>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ Str::limit($item->user->name, 20) }}</td>
                                        <td>{{ Str::limit($item->person_responsible, 20) }}</td>
                                        <td>{!! Str::limit(strip_tags($item->address), 20) !!}</td>
                                        <td>
                                            <a class="text-primary fw-bold" href="https://wa.me/{{ $item->phone_number }}"
                                                target="_blank">
                                                {!! Str::limit($item->phone_number, 20) !!}
                                            </a>
                                        </td>
                                        <td>{{ Str::limit($item->business_type, 20) }}</td>
                                        <td>
                                            @if ($item->available === 'Enabled')
                                                Aktif
                                            @elseif ($item->available === 'Disabled')
                                                Tidak Aktif
                                            @else
                                                Status tidak valid
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.deleteButton').click(function(e) {
                e.preventDefault();

                var itemId = $(this).closest('form').find('input[name="id"]').val();
                var form = $(this).closest('form');

                Swal.fire({
                    icon: 'question',
                    title: 'Apakah anda yakin?',
                    text: "anda ingin menghapus item ini!",
                    showCancelButton: true,
                    confirmButtonText: 'Iya, hapus!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#0F345E',
                    cancelButtonColor: '#BB1F26',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                _method: 'DELETE',
                                item_id: itemId
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Hapus data berhasil',
                                    icon: 'success',
                                    confirmButtonColor: '#0F345E',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                if (xhr.status === 422) {
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: 'Mitra tidak dapat dihapus, karena status masih aktif.',
                                        icon: 'error',
                                        confirmButtonColor: '#0F345E',
                                    });
                                } else if (xhr.status === 419) {
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: 'Tidak dapat menghapus item. Item masih digunakan dalam tabel lain.',
                                        icon: 'error',
                                        confirmButtonColor: '#0F345E',
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: 'Hapus data gagal',
                                        icon: 'error',
                                        confirmButtonColor: '#0F345E',
                                    });
                                }
                            }

                        });
                    }
                });
            });
        });
    </script>
@endsection

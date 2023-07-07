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
                            <h5 class="card-title fw-semibold">Table {{ $title }}</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <a href="/information/create" class="text-decoration-none btn btn-outline-dark mb-3"><i
                                class="ti ti-plus me-1"></i>Add {{ $title }}</a>

                        <table id="category" class="table" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Actions</th>
                                    <th>Title</th>
                                    <th>Username</th>
                                    <th>Description</th>
                                    <th>Available</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="action-links">
                                            @if ($item->user_id === auth()->id())
                                                <a href="{{ route('information.edit', $item->id) }}"
                                                    class="text-decoration-none btn btn-outline-dark mb-3">Edit</a>
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-dark dropdown-toggle" type="button"
                                                        id="moreActionsDropdown" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        More
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="moreActionsDropdown">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('information.show', $item->id) }}"><i
                                                                    class="ti ti-info-circle me-1 text-black"></i>Detail</a>
                                                        </li>
                                                        <form id="formDelete" method="post"
                                                            action="{{ route('information.destroy', $item->id) }}">
                                                            @method('delete')
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $item->id }}">
                                                            <li><button class="dropdown-item deleteButton"><i
                                                                        class="ti ti-trash text-black me-1"
                                                                        onclick="confirm?"></i>Delete</button>
                                                            </li>
                                                        </form>
                                                    </ul>
                                                </div>
                                            @else
                                                <a href="{{ route('information.show', $item->id) }}"
                                                    class="text-decoration-none btn btn-outline-dark mb-3">Detail</a>
                                            @endif
                                        </td>
                                        <td>{{ Str::limit($item->title, 20) }}</td>
                                        <td>{!! Str::limit($item->user->name, 20) !!}</td>
                                        <td>{!! Str::limit($item->description, 20) !!}</td>
                                        <td>{!! Str::limit($item->available, 20) !!}</td>
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
                    title: 'Are you sure?',
                    text: "you want to delete this item!",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete!',
                    cancelButtonText: 'Cancel',
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
                                    title: 'Success',
                                    text: 'Delete data successfully',
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
                                        title: 'Error',
                                        text: 'Cannot to delete item. Status is still enabled.',
                                        icon: 'error',
                                        confirmButtonColor: '#0F345E',
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Delete data failed',
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

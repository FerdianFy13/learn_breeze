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
                        <table id="usermanagement" class="table" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Actions</th>
                                    <th>Role Name</th>
                                    <th>Permission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="action-links">
                                            <div class="dropdown">
                                                <button class="btn btn-outline-dark dropdown-toggle me-2" type="button"
                                                    id="moreActionsDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Edit
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="moreActionsDropdown">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('user.show', $item->id) }}"><i
                                                                class="ti ti-tools me-1 text-black"></i>Edit Permission</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('user.show', $item->id) }}"><i
                                                                class="ti ti-edit me-1 text-black"></i>Edit Role</a>
                                                    </li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('user.show', $item->id) }}"><i
                                                                class="ti ti-pencil me-1 text-black"></i>Edit User</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-dark dropdown-toggle" type="button"
                                                    id="moreActionsDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    More
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="moreActionsDropdown">
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('user.show', $item->id) }}"><i
                                                                class="ti ti-info-circle me-1 text-black"></i>Detail</a>
                                                    </li>
                                                    <form id="formDelete" method="post"
                                                        action="{{ route('user.destroy', $item->id) }}">
                                                        @method('delete')
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                                        <li><button class="dropdown-item deleteButton"><i
                                                                    class="ti ti-trash text-black me-1"
                                                                    onclick="confirm?"></i>Delete</button>
                                                        </li>
                                                    </form>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

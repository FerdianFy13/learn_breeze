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
                        <a href="/partner/create" class="text-decoration-none btn btn-outline-dark mb-3"><i
                                class="ti ti-plus me-1"></i>Add {{ $title }}</a>

                        <table id="product" class="table" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Actions</th>
                                    <th>User</th>
                                    <th>Person Responsible</th>
                                    <th>Address</th>
                                    <th>Phone Number</th>
                                    <th>Business Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td class="action-links">
                                            <a href="{{ route('partner.edit', $item->id) }}"
                                                class="text-decoration-none btn btn-outline-dark mb-3">Edit</a>
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
                                                                    onclick="confirm?"></i>Delete</button>
                                                        </li>
                                                    </form>
                                                </ul>
                                            </div>
                                        </td>
                                        <td>{{ Str::limit($item->user->name, 20) }}</td>
                                        <td>{{ Str::limit($item->person_responsible, 20) }}</td>
                                        <td>{!! Str::limit(strip_tags($item->address), 20) !!}</td>
                                        <td>{{ $item->phone_number }}</td>
                                        <td>{{ Str::limit($item->business_type, 20) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

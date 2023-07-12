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
                    @if (session()->has('success'))
                        <div class="alert alert-success text-dark alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        {{-- <div class="alert alert-success text-dark" role="alert">
                            {{ session('success') }}
                        </div> --}}
                    @endif

                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Table {{ $title }}</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="product" class="table" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>Actions</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @role('Super Administrator')
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="action-links">
                                                <a href="{{ route('user.show', $item->id) }}"
                                                    class="text-decoration-none btn btn-outline-dark mb-3">Detail</a>
                                            </td>
                                            <td>{{ Str::limit($item->name, 20) }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                <a href="{{ route('user.edituser', $item->id) }}"
                                                    class="btn btn-danger">{{ $item->getRoleNames()->implode(', ') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endrole
                                @role('Administrator')
                                    @foreach ($data as $item)
                                        @unless ($item->hasRole('Super Administrator'))
                                            <tr>
                                                <td class="action-links">
                                                    <a href="{{ route('user.show', $item->id) }}"
                                                        class="text-decoration-none btn btn-outline-dark mb-3">Detail</a>
                                                </td>
                                                <td>{{ Str::limit($item->name, 20) }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>
                                                    <a href="{{ route('user.edituser', $item->id) }}"
                                                        class="btn btn-danger">{{ $item->getRoleNames()->implode(', ') }}</a>
                                                </td>
                                            </tr>
                                        @endunless
                                    @endforeach
                                @endrole
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

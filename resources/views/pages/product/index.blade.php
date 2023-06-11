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
                        <h5 class="card-title fw-semibold">Table Product</h5>
                    </div>
                </div>
                <div class="table-responsive">
                    <a href="/product/create" class="text-decoration-none btn btn-outline-dark mb-3"><i
                            class="ti ti-plus me-1"></i>Add {{ $title
                        }}</a>

                    <table id="example" class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>Actions</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Available</th>
                                <th>Stock</th>
                                <th>Image</th>
                                <th>Weight</th>
                                <th>Country</th>
                                <th>Expiration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <td class="action-links">
                                    <a href="/product/create"
                                        class="text-decoration-none btn btn-outline-dark mb-3">Edit</a>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-dark dropdown-toggle" type="button"
                                            id="moreActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            More
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="moreActionsDropdown">
                                            <li><a class="dropdown-item" href="/product/create"><i
                                                        class="ti ti-info-circle me-1 text-black"></i>Detail</a></li>
                                            <li><a class="dropdown-item" href="/product/create"><i
                                                        class="ti ti-trash text-black me-1"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{{ $item->product_name }}</td>
                                <td>{!! $item->description !!}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->category }}</td>
                                <td>{{ $item->available }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>{{ $item->image }}</td>
                                <td>{{ $item->weight }}</td>
                                <td>{{ $item->origin_country }}</td>
                                <td>{{ $item->expiration_date }}</td>
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
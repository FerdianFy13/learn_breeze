@extends('layouts.backend')

@section('backend_content')
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
                    <table id="example" class="table" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Category</th>
                                <th>Available</th>
                                <th>Stock</th>
                                <th>Weight</th>
                                <th>Country</th>
                                <th>Expiration</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
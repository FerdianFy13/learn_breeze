@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Detail Table Role Management</h5>
                            <a href="/role" class="btn btn-outline-dark me-2 mt-3">Back</a>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" required name="name"
                                    value="{{ old('name', $data->name) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputRole" class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputRole" required name="guard_name"
                                    value="{{ old('guard_name', $data->guard_name) }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

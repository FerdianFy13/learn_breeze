@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Insert Table Fisherman Manage</h5>
                            <a href="/fisherman" class="btn btn-outline-dark me-2 mt-3">Back</a>
                        </div>
                    </div>
                    <div>
                        <form id="formInsert" enctype="multipart/form-data" method="post"
                            action="{{ route('fisherman.update', $data->id) }}">
                            @method('patch')
                            @csrf
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" required name="name"
                                        value="{{ old('name', $data->name) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputUser" class="col-sm-2 col-form-label">User</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" required name="name"
                                        value="{{ old('user_id', $data->user->name) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputShip" class="col-sm-2 col-form-label">Ship Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputShip" required name="ship_name"
                                        value="{{ old('ship_name', $data->ship_name) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputOwner" class="col-sm-2 col-form-label">Ship Owner</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputOwner" required name="ship_owner"
                                        value="{{ old('ship_owner', $data->ship_owner) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputType" class="col-sm-2 col-form-label">Type Ship</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputType" required name="type_ship"
                                        value="{{ old('type_ship', $data->type_ship) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPhone" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPhone" required name="phone_number"
                                        value="{{ old('phone_number', $data->phone_number) }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputResult" class="col-sm-2 col-form-label">Result Member</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputResult" required
                                        name="result_member" value="{{ old('result_member', $data->result_member) }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputAvailable" class="col-sm-2 col-form-label">Available</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputResult" required
                                        name="result_member" value="{{ old('available', $data->available) }}" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

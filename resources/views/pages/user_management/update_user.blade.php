@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Detail Table User Management || {{ $data->name }}</h5>
                            <a href="/user" class="btn btn-outline-dark me-2 mt-3">Back</a>
                        </div>
                    </div>
                    <div>
                        <form id="formInsert" enctype="multipart/form-data" method="post"
                            action="{{ route('user.updateuser', $data->id) }}">
                            @csrf
                            @method('put')
                            <div class="mb-3 row">
                                <label for="inputRole" class="col-sm-2 col-form-label">Role</label>
                                <div class="col-sm-10">
                                    <select class="form-select" data-live-search="true" name="role">
                                        @foreach ($role as $role)
                                            <option data-tokens="{{ $role->name }}" value="{{ $role->name }}"
                                                @if ($data->hasRole($role->name)) selected @endif>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="float-end">
                                <a href="/user" class="btn btn-outline-dark me-2">Cancel</a>
                                <button type="submit" class="btn btn-danger">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

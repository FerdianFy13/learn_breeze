@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Insert Table Fisherman Manage</h5>
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
                                        value="{{ old('name', $data->name) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputUser" class="col-sm-2 col-form-label">User</label>
                                <div class="col-sm-10">
                                    <div class="mt-1">
                                        <select class="form-control" name="user_id" required>
                                            <option selected>Please select user name</option>
                                            @foreach ($query as $item)
                                                @if ($item->hasRole('Member'))
                                                    @if (old('user_id', $data->user_id) == $item->id)
                                                        <option value="{{ $item->id }}" selected>{{ $item->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputShip" class="col-sm-2 col-form-label">Ship Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputShip" required name="ship_name"
                                        value="{{ old('ship_name', $data->ship_name) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputOwner" class="col-sm-2 col-form-label">Ship Owner</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputOwner" required name="ship_owner"
                                        value="{{ old('ship_owner', $data->ship_owner) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputType" class="col-sm-2 col-form-label">Type Ship</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputType" required name="type_ship"
                                        value="{{ old('type_ship', $data->type_ship) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPhone" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPhone" required name="phone_number"
                                        value="{{ old('phone_number', $data->phone_number) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputResult" class="col-sm-2 col-form-label">Result Member</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputResult" required
                                        name="result_member" value="{{ old('result_member', $data->result_member) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputAvailable" class="col-sm-2 col-form-label">Available</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="available" id="inputEnabled"
                                            value="Enabled" required checked
                                            {{ old('available') == 'Enabled' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputEnabled">Enabled</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="available" id="inputDisabled"
                                            value="Disabled" required
                                            {{ old('available') == 'Disabled' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputDisabled">Disabled</label>
                                    </div>
                                </div>
                            </div>
                            <div class="float-end">
                                <a href="/fisherman" class="btn btn-outline-dark me-2">Cancel</a>
                                <button type="submit" class="btn btn-danger">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var inputName = document.getElementById('inputName');
        var inputShip = document.getElementById('inputShip');
        var inputOwner = document.getElementById('inputOwner');
        var inputType = document.getElementById('inputType');

        inputName.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        })

        inputShip.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        });

        inputOwner.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        });

        inputType.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        });

        function sanitizeInputChar(inputValue) {
            var sanitizedValue = inputValue.replace(/[^A-Za-z\s]/g, '');
            return sanitizedValue;
        }

        var inputPhone = document.getElementById('inputPhone');
        var inputResult = document.getElementById('inputResult');

        inputPhone.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInput(inputValue);
            e.target.value = sanitizedValue;
        });

        inputResult.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInput(inputValue);
            e.target.value = sanitizedValue;
        });

        function sanitizeInput(inputValue) {
            var sanitizedValue = inputValue.replace(/\D/g, '');
            return sanitizedValue;
        }
    </script>

    <script>
        $('#formInsert').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            Swal.fire({
                icon: 'question',
                title: 'Are you sure?',
                text: 'Make sure all the data entered is correct',
                showCancelButton: true,
                confirmButtonText: 'Yes, I sure',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#0F345E',
                cancelButtonColor: '#BB1F26',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $('#formInsert').attr('action'),
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Update data successfully',
                                icon: 'success',
                                confirmButtonColor: '#0F345E',
                            }).then((result) => {
                                window.location.href = '/fisherman';
                            });
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                var errors = xhr.responseJSON.errors;
                                var errorMessage = '';

                                for (var key in errors) {
                                    errorMessage += errors[key][0] + '\n';
                                }

                                Swal.fire({
                                    title: 'Validation Error',
                                    text: errorMessage,
                                    icon: 'error',
                                    confirmButtonColor: '#0F345E',
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Update data failed',
                                    icon: 'error',
                                    confirmButtonColor: '#0F345E',
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection

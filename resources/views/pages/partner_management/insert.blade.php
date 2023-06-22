@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Insert Table Partner Management</h5>
                        </div>
                    </div>
                    <div>
                        <form id="formInsert" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 row">
                                <label for="inputUser" class="col-sm-2 col-form-label">User</label>
                                <div class="col-sm-10">
                                    <div class="mt-1">
                                        <select class="form-control" name="user_id" required>
                                            <option selected>Please select user name</option>
                                            @foreach ($data as $item)
                                                @if ($item->hasRole('Partner'))
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPerson" class="col-sm-2 col-form-label">Person Responsible</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPerson" required
                                        name="person_responsible" value="{{ old('person_responsible') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="hidden" name="address" id="inputAddress" required
                                        value="{{ old('address') }}">
                                    <trix-editor input="inputAddress"></trix-editor>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPhone" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPhone" required name="phone_number"
                                        value="{{ old('phone_number') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputBusiness" class="col-sm-2 col-form-label">Business Type</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputBusiness" required
                                        name="business_type" value="{{ old('business_type') }}">
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
                                            value="Disabled" required {{ old('available') == 'Disabled' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputDisabled">Disabled</label>
                                    </div>
                                </div>
                            </div>
                            <div class="float-end">
                                <a href="/partner" class="btn btn-outline-dark me-2">Cancel</a>
                                <button type="submit" class="btn btn-danger">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var inputPerson = document.getElementById('inputPerson');
        var inputBusiness = document.getElementById('inputBusiness');

        inputPerson.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        })

        inputBusiness.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        });

        function sanitizeInputChar(inputValue) {
            var sanitizedValue = inputValue.replace(/[^A-Za-z\s]/g, '');
            return sanitizedValue;
        }

        var inputPhone = document.getElementById('inputPhone');

        inputPhone.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInput(inputValue);
            var maxLength = 13;
            if (sanitizedValue.length > maxLength) {
                sanitizedValue = sanitizedValue.slice(0, maxLength);
            }
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
                        url: '/partner',
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Insert data successfully',
                                icon: 'success',
                                confirmButtonColor: '#0F345E',
                            }).then((result) => {
                                window.location.href = '/partner';
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
                                    text: 'Insert data failed',
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

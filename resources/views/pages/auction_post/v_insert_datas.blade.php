@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Insert Table Product</h5>
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
                                                @if ($item->hasRole('Supervisor'))
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" required name="product_name"
                                        value="{{ old('product_name') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="hidden" name="description" id="inputDescription"
                                        required value="{{ old('description') }}">
                                    <trix-editor input="inputDescription"></trix-editor>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPrice" class="col-sm-2 col-form-label">Open Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPrice" required name="open_price"
                                        value="{{ old('price') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputWeight" class="col-sm-2 col-form-label">Product Weight</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputWeight" required
                                        name="product_weight" step="any" value="{{ old('product_weight') }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputQuality" class="col-sm-2 col-form-label">Product Quality</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="product_quality" id="inputLow"
                                            value="Low" required {{ old('product_quality') == 'Low' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputLow">Low</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="product_quality"
                                            id="inputMedium" value="Medium" required
                                            {{ old('product_quality') == 'Medium' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputMedium">Medium</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="product_quality" id="inputHigh"
                                            value="High" required {{ old('product_quality') == 'High' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputHigh">High</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label for="inputImage" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" accept=".jpg, .png, .jpeg" class="form-control" id="inputImage"
                                        onchange="previewImage()" required name="image" value="{{ old('image') }}">
                                    <div class="image-preview-container mt-3">
                                        <button type="button" onclick="resetImage()" class="btn btn-secondary mb-2"
                                            id="resetButton" style="display: none;">Reset</button>
                                        <img class="img-preview img-fluid col-sm-7 mb-3" id="imagePreview">
                                    </div>
                                </div>
                            </div>
                            <div class="float-end">
                                <a href="/post" class="btn btn-outline-dark me-2">Cancel</a>
                                <button type="submit" class="btn btn-danger">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const image = document.querySelector('#inputImage');
            const previewImages = document.querySelector('#imagePreview');
            const resetButton = document.querySelector('#resetButton');

            if (image.files && image.files[0]) {
                const ofReader = new FileReader();
                ofReader.readAsDataURL(image.files[0]);

                ofReader.onload = function(oFREvent) {
                    previewImages.src = oFREvent.target.result;
                    resetButton.style.display = 'block';
                };
            } else {
                previewImages.src = '';
                resetButton.style.display = 'none';
            }
        }

        function resetImage() {
            const input = document.getElementById('inputImage');
            const preview = document.getElementById('imagePreview');
            const resetButton = document.getElementById('resetButton');
            input.value = null;
            preview.src = '';
            resetButton.style.display = 'none';
        }

        var inputQuality = document.getElementById('inputQuality');
        var inputName = document.getElementById('inputName');

        inputName.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        })

        inputQuality.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        });

        function sanitizeInputChar(inputValue) {
            var sanitizedValue = inputValue.replace(/[^A-Za-z\s]/g, '');
            return sanitizedValue;
        }

        var inputPrice = document.getElementById('inputPrice');

        inputPrice.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInput(inputValue);
            e.target.value = sanitizedValue;
        });

        function sanitizeInput(inputValue) {
            var sanitizedValue = inputValue.replace(/\D/g, '');
            return sanitizedValue;
        }

        var inputWeight = document.getElementById('inputWeight');

        inputWeight.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputDecimal(inputValue);
            e.target.value = sanitizedValue;
        });

        function sanitizeInputDecimal(input) {
            var sanitizedValue = input.replace(/[^0-9,]/g, '');
            sanitizedValue = sanitizedValue.replace(/,/g, '.');

            var dotCount = sanitizedValue.split('.').length - 1;
            if (dotCount > 1) {
                sanitizedValue = sanitizedValue.replace(/\./g, '');
            }

            sanitizedValue = sanitizedValue.replace(/^\./, '');

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
                        url: '/post',
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
                                window.location.href = '/post';
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

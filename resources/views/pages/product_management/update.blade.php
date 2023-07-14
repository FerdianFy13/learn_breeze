@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Update Table Product Management</h5>
                        </div>
                    </div>
                    <div>
                        <form id="formInsert" enctype="multipart/form-data" method="post"
                            action="{{ route('products.update', $data->id) }}">
                            @method('patch')
                            @csrf
                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputTitle" required name="title"
                                        value="{{ old('title', $data->title) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputUser" class="col-sm-2 col-form-label">User</label>
                                <div class="col-sm-10">
                                    <div class="mt-1">
                                        <select class="form-control" name="user_id" required>
                                            <option selected>Please select user name</option>
                                            @foreach ($user as $item)
                                                @if ($item->hasRole('Supervisor'))
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
                                <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="hidden" name="description" id="inputDescription"
                                        required value="{{ old('description', $data->description) }}">
                                    <trix-editor input="inputDescription"></trix-editor>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPrice" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPrice" required name="price"
                                        value="{{ old('price', $data->price) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPhone" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPhone" required name="phone_number"
                                        placeholder="62 xxxxxxxxxxx" value="{{ old('phone_number', $data->phone_number) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputInstagram" class="col-sm-2 col-form-label">Instagram</label>
                                <div class="col-sm-10">
                                    <input type="url" class="form-control" id="inputInstagram" required name="instagram"
                                        value="{{ old('instagram', $data->instagram) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputAvailable" class="col-sm-2 col-form-label">Available</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="available" id="inputEnabled"
                                            value="Enabled" required
                                            {{ old('available', $data->available) == 'Enabled' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputEnabled">Enabled</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="available" id="inputDisabled"
                                            value="Disabled" required
                                            {{ old('available', $data->available) == 'Disabled' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputDisabled">Disabled</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label for="inputImage" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" accept=".jpg, .png, .jpeg" class="form-control" id="inputImage"
                                        onchange="previewImage()" name="image" value="{{ old('image', $data->image) }}">
                                    <div class="image-preview-container">
                                        <button type="button" onclick="resetImage()" class="btn btn-secondary mb-2 mt-3"
                                            id="resetButton">Reset</button>
                                        <img class="img-preview img-fluid col-sm-7 mb-3 mt-2" id="imagePreview">
                                        @if (Storage::exists($data->image))
                                            <img class="img-preview img-fluid col-sm-7 mb-3 mt-2"
                                                src="{{ asset('storage/' . $data->image) }}" id="imagePreviewDefault">
                                        @else
                                            <p class="form-control" id="previewCondition">Image not found in directory
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="float-end">
                                <a href="/products" class="btn btn-outline-dark me-2">Cancel</a>
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
            const imagePreviewDefault = document.getElementById("imagePreviewDefault");

            if (image.files && image.files[0]) {
                const ofReader = new FileReader();
                ofReader.readAsDataURL(image.files[0]);

                ofReader.onload = function(oFREvent) {
                    previewImages.src = oFREvent.target.result;
                    resetButton.style.display = 'block';
                    imagePreviewDefault.style.display = 'none';
                };
            } else {
                previewImages.src = '';
                resetButton.style.display = 'none';
            }
        }

        function resetImage() {
            const input = document.getElementById('inputImage');
            const preview = document.getElementById('imagePreview');
            const preview2 = document.getElementById('imagePreviewDefault');
            const resetButton = document.getElementById('resetButton');
            input.value = null;
            preview.src = '';
            preview2.src = '';
            resetButton.style.display = 'none';
        }

        var inputTitle = document.getElementById('inputTitle');

        inputTitle.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        })

        function sanitizeInputChar(inputValue) {
            var sanitizedValue = inputValue.replace(/[^A-Za-z\s]/g, '');
            return sanitizedValue;
        }

        var inputPrice = document.getElementById('inputPrice');
        var inputPhone = document.getElementById('inputPhone');

        inputPrice.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInput(inputValue);
            e.target.value = sanitizedValue;
        });

        inputPhone.addEventListener('input', function(e) {
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
                                window.location.href = '/products';
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

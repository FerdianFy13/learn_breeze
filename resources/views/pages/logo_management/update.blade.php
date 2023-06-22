@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Update Table Logo Management</h5>
                        </div>
                    </div>
                    <div>
                        <form id="formInsert" enctype="multipart/form-data" method="post"
                            action="{{ route('logo.update', $data->id) }}">
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
                                <label for="inputCategory" class="col-sm-2 col-form-label">Partner</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="partner_id" required>
                                        <option selected>Please select logo partner</option>
                                        @foreach ($query as $item)
                                            @if (old('partner_id', $data->partner_id) == $item->id)
                                                <option value="{{ $item->id }}" selected>{{ $item->person_responsible }}
                                                </option>
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->person_responsible }}</option>
                                            @endif
                                        @endforeach
                                    </select>
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
                                <a href="/logo" class="btn btn-outline-dark me-2">Cancel</a>
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

        var inputName = document.getElementById('inputName');

        inputName.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        })

        function sanitizeInputChar(inputValue) {
            var sanitizedValue = inputValue.replace(/[^A-Za-z\s]/g, '');
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
                                window.location.href = '/logo';
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

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
                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" required name="product_name">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputDescription" name="description"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPrice" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPrice" required name="price">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputCategory" class="col-sm-2 col-form-label">Category</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputCategory" required name="category">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputAvailable" class="col-sm-2 col-form-label">Available</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="available" id="inputEnabled"
                                            value="Enabled" required checked>
                                        <label class="form-check-label" for="inputEnabled">Enabled</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="available" id="inputDisabled"
                                            value="Disabled" required>
                                        <label class="form-check-label" for="inputDisabled">Disabled</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputStock" class="col-sm-2 col-form-label">Stock</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputStock" required name="stock">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputExpiration" class="col-sm-2 col-form-label">Expiration</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="inputExpiration" required
                                        name="expiration_date">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputWeight" class="col-sm-2 col-form-label">Weight</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputWeight" required name="weight">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputCountry" class="col-sm-2 col-form-label">Country</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputCountry" required
                                        name="origin_country">
                                </div>
                            </div>
                            <div class="row">
                                <label for="inputImage" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" accept=".jpg, .png, .jpeg" class="form-control" id="inputImage"
                                        onchange="previewImage()" required name="image">
                                    <div class="image-preview-container mt-3">
                                        <button type="button" onclick="resetImage()" class="btn btn-secondary mb-2"
                                            id="resetButton" style="display: none;">Reset</button>
                                        <img class="img-preview img-fluid col-sm-7 mb-3" id="imagePreview">
                                    </div>
                                </div>
                            </div>
                            <div class="float-end">
                                <a href="/product" class="btn btn-outline-dark me-2">Cancel</a>
                                <button type="submit" class="btn btn-danger">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            ClassicEditor
                .create(document.querySelector('#inputDescription'))
                .then(editor => {})
                .catch(error => {});
        });

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
                        url: '/product',
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
                                window.location.href = '/product';
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

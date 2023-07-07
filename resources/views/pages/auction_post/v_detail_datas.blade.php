@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Detail Table Datas Post</h5>
                            <a href="/post" class="btn btn-outline-dark me-2 mt-3">Back</a>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <label for="inputCategory" class="col-sm-2 col-form-label">Modified By</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputCategory" required name="category"
                                    value="{{ old('category', $data->user->name) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-2 col-form-label">Product Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" required name="product_name"
                                    value="{{ old('product_name', $data->product_name) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPrice" class="col-sm-2 col-form-label">Open Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPrice" required name="price"
                                    value="{{ old('open_price', 'Rp' . number_format($data->open_price, 2, ',', '.')) }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputAvailable" class="col-sm-2 col-form-label">Product Weight</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputStock" required name="available"
                                    value="{{ old('product_weight', $data->product_weight) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputStock" class="col-sm-2 col-form-label">Product Quality</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputStock" required name="stock"
                                    value="{{ old('product_quality', $data->product_quality) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" rows="3" id="inputDescription" required readonly>{!! strip_tags($data->description) !!}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <label for="inputImage" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                                @if (Storage::exists($data->image))
                                    <img class="img-preview img-fluid col-sm-7 mb-3"
                                        src="{{ asset('storage/' . $data->image) }}" id="imagePreview">
                                @else
                                    <input type="text" class="form-control" id="inputCountry" required
                                        name="origin_country" value="Image not found in storage" readonly>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function adjustTextareaRows() {
            const textarea = document.getElementById('inputDescription');
            textarea.rows = textarea.value.split('\n').length;
        }

        window.addEventListener('DOMContentLoaded', adjustTextareaRows);
        document.getElementById('inputDescription').addEventListener('input', adjustTextareaRows);

        const inputFields = document.querySelectorAll('.form-control');

        inputFields.forEach(function(input) {
            input.setAttribute('readonly', 'readonly');
            input.addEventListener('focus', function() {
                this.blur();
            });
        });
    </script>
@endsection

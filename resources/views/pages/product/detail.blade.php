@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Detail Table Product</h5>
                            <a href="/product" class="btn btn-outline-dark me-2 mt-3">Back</a>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" required name="product_name"
                                    value="{{ old('product_name', $data->product_name) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" rows="3" id="inputDescription" required readonly>{!! strip_tags($data->description) !!}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPrice" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPrice" required name="price"
                                    value="{{ old('price', 'Rp' . number_format($data->price, 2, ',', '.')) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputCategory" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputCategory" required name="category"
                                    value="{{ old('category', $data->category->name) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputAvailable" class="col-sm-2 col-form-label">Available</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputStock" required name="available"
                                    value="{{ old('available', $data->available) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputStock" class="col-sm-2 col-form-label">Stock</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="inputStock" required name="stock"
                                    value="{{ old('stock', number_format($data->stock, 0, ',', '.')) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputExpiration" class="col-sm-2 col-form-label">Expiration</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputExpiration" required
                                    name="expiration_date"
                                    value="{{ old('expiration_date', date('d F Y', strtotime($data->expiration_date))) }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputWeight" class="col-sm-2 col-form-label">Weight</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="inputWeight" required name="weight"
                                    value="{{ old('weight', number_format($data->weight, 0, ',', '.')) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputCountry" class="col-sm-2 col-form-label">Country</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputCountry" required name="origin_country"
                                    value="{{ old('origin_country', $data->origin_country) }}" readonly>
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

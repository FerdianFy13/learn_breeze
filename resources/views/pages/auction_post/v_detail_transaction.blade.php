@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Detail Table Transaction Post</h5>
                            <a href="/post" class="btn btn-outline-dark me-2 mt-3">Back</a>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <label for="inputCategory" class="col-sm-2 col-form-label">User</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputCategory" required name="category"
                                    value="{{ old('category', $data->user->name) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputCategory" class="col-sm-2 col-form-label">Partner</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputCategory" required name="category"
                                    value="{{ old('category', $data->partner->person_responsible) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-2 col-form-label">Product Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" required name="product_name"
                                    value="{{ old('product_name', $data->auction->product_name) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-2 col-form-label">Transaction Number</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" required name="transaction_number"
                                    value="{{ old('transaction_number', $data->transaction_number) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPrice" class="col-sm-2 col-form-label">Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPrice" required name="price"
                                    value="{{ old('open_price', 'Rp' . number_format($data->price, 2, ',', '.')) }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPrice" class="col-sm-2 col-form-label">Retribution Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPrice" required name="price"
                                    value="{{ old('retribution_price', 'Rp' . number_format($data->retribution_price, 2, ',', '.')) }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPrice" class="col-sm-2 col-form-label">Baragain Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPrice" required name="price"
                                    value="{{ old('bargain_price', 'Rp' . number_format($data->bargain_price, 2, ',', '.')) }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPrice" class="col-sm-2 col-form-label">Baragain Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPrice" required name="price"
                                    value="{{ old('bargain_price', 'Rp' . number_format($data->bargain_price, 2, ',', '.')) }}"
                                    readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" required name="product_name"
                                    value="{{ old('status', $data->status) }}" readonly>
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
                                        name="origin_country"
                                        value="Image not found in storage and There is no proof of payment yet" readonly>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Update Table Auction Post</h5>
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
                        <form id="formInsert" enctype="multipart/form-data" method="post"
                            action="{{ route('auction.update', $data->id) }}">
                            @method('patch')
                            @csrf
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inputLow"
                                            value="Pending" required
                                            {{ old('status', $data->status) == 'Pending' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputLow">Pending</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inputMedium"
                                            value="Accepted" required
                                            {{ old('status', $data->status) == 'Accepted' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputMedium">Accepted</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inputHigh"
                                            value="Rejected" required
                                            {{ old('status', $data->status) == 'Rejected' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputHigh">Rejected</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inputHigh"
                                            value="Canceled" required
                                            {{ old('status', $data->status) == 'Canceled' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputHigh">Canceled</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="status" id="inputHigh"
                                            value="Completed" required
                                            {{ old('status', $data->status) == 'Completed' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputHigh">Completed</label>
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

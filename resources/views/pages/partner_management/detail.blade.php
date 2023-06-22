@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Insert Table Partner Management</h5>
                            <a href="/partner" class="btn btn-outline-dark me-2 mt-3">Back</a>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <label for="inputUser" class="col-sm-2 col-form-label">User</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPerson" required
                                    name="person_responsible" value="{{ old('user_id', $data->user->name) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPerson" class="col-sm-2 col-form-label">Person Responsible</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPerson" required
                                    name="person_responsible"
                                    value="{{ old('person_responsible', $data->person_responsible) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" rows="3" id="inputAddress" required readonly>{!! strip_tags($data->address) !!}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputPhone" class="col-sm-2 col-form-label">Phone Number</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="inputPhone" required name="phone_number"
                                    value="{{ old('phone_number', $data->phone_number) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputBusiness" class="col-sm-2 col-form-label">Business Type</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputBusiness" required name="business_type"
                                    value="{{ old('business_type', $data->business_type) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputAvailable" class="col-sm-2 col-form-label">Available</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputStock" required name="available"
                                    value="{{ old('available', $data->available) }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var inputAddress = document.getElementById('inputAddress');

        inputAddress.addEventListener('input', function() {
            autoResizeTextarea(this);
        });

        function autoResizeTextarea(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }


        const inputFields = document.querySelectorAll('.form-control');

        inputFields.forEach(function(input) {
            input.setAttribute('readonly', 'readonly');
            input.addEventListener('focus', function() {
                this.blur();
            });
        });
    </script>
@endsection

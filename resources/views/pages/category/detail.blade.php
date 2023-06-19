@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Detail Table Category</h5>
                            <a href="/category" class="btn btn-outline-dark me-2 mt-3">Back</a>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" required name="name"
                                    value="{{ old('name', $data->name) }}" readonly>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputDescription" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description" rows="3" id="inputDescription" required readonly>{!! strip_tags($data->description) !!}</textarea>
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

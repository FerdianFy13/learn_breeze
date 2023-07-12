@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Update Tabel Manajemen Mitra</h5>
                        </div>
                    </div>
                    <div>
                        <form id="formInsert" enctype="multipart/form-data" method="post"
                            action="{{ route('partner.update', $data->id) }}">
                            @method('patch')
                            @csrf
                            <div class="mb-3 row">
                                <label for="inputUser" class="col-sm-2 col-form-label">User</label>
                                <div class="col-sm-10">
                                    <div class="mt-1">
                                        <select class="form-control" name="user_id" required>
                                            <option selected>Silahkan pilih nama user</option>
                                            @foreach ($user as $item)
                                                @if ($item->hasRole('Partner'))
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
                                <label for="inputPerson" class="col-sm-2 col-form-label">Penanggung Jawab</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputPerson" required
                                        name="person_responsible"
                                        value="{{ old('person_responsible', $data->person_responsible) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputAddress" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="hidden" name="address" id="inputAddress" required
                                        value="{{ old('address', $data->address) }}">
                                    <trix-editor input="inputAddress"></trix-editor>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPhone" class="col-sm-2 col-form-label">Nomer Telepon</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPhone" required name="phone_number"
                                        placeholder="6281345678902" value="{{ old('phone_number', $data->phone_number) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputBusiness" class="col-sm-2 col-form-label">Jenis Usaha</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputBusiness" required
                                        name="business_type" value="{{ old('business_type', $data->business_type) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputAvailable" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="available" id="inputEnabled"
                                            value="Enabled" required
                                            {{ old('available', $data->available) == 'Enabled' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputEnabled">Aktif</label>
                                    </div>
                                    <div class="form-check form-check-inline mt-2">
                                        <input class="form-check-input" type="radio" name="available" id="inputDisabled"
                                            value="Disabled" required
                                            {{ old('available', $data->available) == 'Disabled' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="inputDisabled">Tidak Aktif</label>
                                    </div>
                                </div>
                            </div>
                            <div class="float-end">
                                <a href="/partner" class="btn btn-outline-dark me-2">Batal</a>
                                <button type="submit" class="btn btn-danger">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var inputPerson = document.getElementById('inputPerson');
        var inputBusiness = document.getElementById('inputBusiness');

        inputPerson.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        })

        inputBusiness.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInputChar(inputValue);
            e.target.value = sanitizedValue;
        });

        function sanitizeInputChar(inputValue) {
            var sanitizedValue = inputValue.replace(/[^A-Za-z\s]/g, '');
            return sanitizedValue;
        }

        var inputPhone = document.getElementById('inputPhone');

        inputPhone.addEventListener('input', function(e) {
            var inputValue = e.target.value;
            var sanitizedValue = sanitizeInput(inputValue);
            var maxLength = 13;
            if (sanitizedValue.length > maxLength) {
                sanitizedValue = sanitizedValue.slice(0, maxLength);
            }
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
                title: 'Apakah anda yakin?',
                text: 'Pastikan semua data yang dimasukkan sudah benar',
                showCancelButton: true,
                confirmButtonText: 'Iya, Saya yakin',
                cancelButtonText: 'Batal',
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
                                title: 'Berhasil',
                                text: 'Ubah data berhasil',
                                icon: 'success',
                                confirmButtonColor: '#0F345E',
                            }).then((result) => {
                                window.location.href = '/partner';
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
                                    title: 'Gagal',
                                    text: 'Update data gagal',
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

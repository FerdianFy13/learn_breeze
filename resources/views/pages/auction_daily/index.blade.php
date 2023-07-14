@extends('layouts.backend')

@section('backend_content')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <img class="img-fluid" src="{{ asset('dist/images/slideshow/banner2.jpg') }}" alt="image banner">
                        </div>
                    </div>
                    <div class="auction-daily">
                        <h5 class="card-title" style="font-weight: 500">It's being auctioned right now</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

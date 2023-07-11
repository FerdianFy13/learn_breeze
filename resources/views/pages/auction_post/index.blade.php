@extends('layouts.backend')

@section('backend_content')
    <style>
        .action-links {
            display: flex;
            flex-direction: row;
        }

        .action-links a {
            margin-right: 10px;
        }

        .nav-link.active {
            color: #fff;
            font-weight: 600;
        }

        .nav-link:not(.active) {
            color: #000;
            font-weight: 500;
        }

        #transaction-category {
            width: 100%;
        }

        @media (max-width: 767.98px) {
            .nav-pills .nav-item {
                flex: 0 0 33.33%;
                max-width: 33.33%;
            }
        }
    </style>

    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    @role('Supervisor')
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="auction-tab" data-bs-toggle="tab"
                                    data-bs-target="#auction-tab-pane" type="button" role="tab"
                                    aria-controls="auction-tab-pane" aria-selected="true">Auction Post</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="transaction-tab" data-bs-toggle="tab"
                                    data-bs-target="#transaction-tab-pane" type="button" role="tab"
                                    aria-controls="transaction-tab-pane" aria-selected="false">Transaction Post</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="datas-tab" data-bs-toggle="tab" data-bs-target="#datas-tab-pane"
                                    type="button" role="tab" aria-controls="datas-tab-pane" aria-selected="false">Data
                                    Post</button>
                            </li>
                        </ul>
                        <div class="tab-content mt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="auction-tab-pane" role="tabpanel"
                                aria-labelledby="auction-tab" tabindex="0">
                                @include('pages.auction_post.v_auction')
                            </div>
                            <div class="tab-pane fade" id="transaction-tab-pane" role="tabpanel"
                                aria-labelledby="transaction-tab" tabindex="0">
                                @include('pages.auction_post.v_transaction')
                            </div>
                            <div class="tab-pane fade" id="datas-tab-pane" role="tabpanel" aria-labelledby="datas-tab"
                                tabindex="0">
                                @include('pages.auction_post.v_datas')
                            </div>
                        </div>
                    @endrole
                    @role('Agency')
                        <ul class="nav nav-pills" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="transaction2-tab" data-bs-toggle="tab"
                                    data-bs-target="#transaction2-tab-pane" type="button" role="tab"
                                    aria-controls="transaction2-tab-pane" aria-selected="true">Transaction Post</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="datas2-tab" data-bs-toggle="tab" data-bs-target="#datas2-tab-pane"
                                    type="button" role="tab" aria-controls="datas2-tab-pane" aria-selected="false">Data
                                    Post</button>
                            </li>
                        </ul>
                        <div class="tab-content mt-4" id="myTabContent">
                            <div class="tab-pane fade show active" id="transaction2-tab-pane" role="tabpanel"
                                aria-labelledby="transaction2-tab" tabindex="0">
                                @include('pages.auction_post.v_transaction')
                            </div>
                            <div class="tab-pane fade" id="datas2-tab-pane" role="tabpanel" aria-labelledby="datas2-tab"
                                tabindex="0">
                                @include('pages.auction_post.v_datas')
                            </div>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>

    @role('Supervisor')
        <script>
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabPanes.forEach(pane => {
                if (pane.id !== 'auction-tab-pane') {
                    pane.classList.remove('show');
                }
            });

            document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((el) => {
                el.addEventListener('shown.bs.tab', () => {
                    DataTable.tables({
                        visible: true,
                        api: true
                    }).columns.adjust();
                });
            })
        </script>
    @endrole

    @role('Agency')
        <script>
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabPanes.forEach(pane => {
                if (pane.id !== 'transaction2-tab-pane') {
                    pane.classList.remove('show');
                }
            });

            document.querySelectorAll('button[data-bs-toggle="tab"]').forEach((el) => {
                el.addEventListener('shown.bs.tab', () => {
                    DataTable.tables({
                        visible: true,
                        api: true
                    }).columns.adjust();
                });
            })
        </script>
    @endrole

    {{-- <script>
        $(document).ready(function() {
            $('.deleteButton').click(function(e) {
                e.preventDefault();

                var itemId = $(this).closest('form').find('input[name="id"]').val();
                var form = $(this).closest('form');

                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure?',
                    text: "you want to delete this item!",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#0F345E',
                    cancelButtonColor: '#BB1F26',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: form.attr('action'),
                            type: 'POST',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                _method: 'DELETE',
                                item_id: itemId
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Delete data successfully',
                                    icon: 'success',
                                    confirmButtonColor: '#0F345E',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                if (xhr.status === 422) {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Cannot delete item. It is still used in other records.',
                                        icon: 'error',
                                        confirmButtonColor: '#0F345E',
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'Delete data failed',
                                        icon: 'error',
                                        confirmButtonColor: '#0F345E',
                                    });
                                }
                            }

                        });
                    }
                });
            });
        });
    </script> --}}
@endsection

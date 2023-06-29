<div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
    <div class="mb-3 mb-sm-0">
        <h5 class="card-title fw-semibold">Table {{ $title_b }}</h5>
    </div>
</div>
<div class="table-responsive">
    <a href="/transaction/create" class="text-decoration-none btn btn-outline-dark mb-3"><i class="ti ti-plus me-1"></i>Add
        {{ $title_b }}</a>

    <table id="transaction-category" class="table" style="width:100%">
        <thead class="table-light">
            <tr>
                <th>Actions</th>
                <th>Transaction Number</th>
                <th>Partner</th>
                <th>Transfer Evidience</th>
                <th>Product Purchased</th>
                <th>Auction Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction as $item)
                <tr>
                    <td class="action-links">
                        <a href="{{ route('transaction.edit', $item->id) }}"
                            class="text-decoration-none btn btn-outline-dark mb-3">Edit</a>
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="moreActionsDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                More
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="moreActionsDropdown">
                                <li><a class="dropdown-item" href="{{ route('transaction.show', $item->id) }}"><i
                                            class="ti ti-info-circle me-1 text-black"></i>Detail</a>
                                </li>
                                <form id="formDelete" method="post"
                                    action="{{ route('transaction.destroy', $item->id) }}">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                    <li><button class="dropdown-item deleteButton"><i
                                                class="ti ti-trash text-black me-1"
                                                onclick="confirm?"></i>Delete</button>
                                    </li>
                                </form>
                            </ul>
                        </div>
                    </td>
                    <td>{{ Str::limit($item->transaction_number, 20) }}</td>
                    <td>{!! Str::limit($item->partner->person_responsible, 20) !!}</td>
                    <td>
                        @if ($item->image)
                            Proof of Payment Exists
                        @else
                            Proof of Payment Blank
                        @endif
                    </td>
                    <td>{{ $item->auction->product_name }}</td>
                    <td>{!! Str::limit($item->price, 20) !!}</td>
                    <td>{!! Str::limit($item->status, 20) !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
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
                                    text: 'Transaction Post cannot be deleted because it is currently accepted or completed',
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
</script>

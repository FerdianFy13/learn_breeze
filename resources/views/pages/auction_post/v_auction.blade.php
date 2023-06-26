<div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
    <div class="mb-3 mb-sm-0">
        <h5 class="card-title fw-semibold">Table {{ $title_a }}</h5>
    </div>
</div>
<div class="table-responsive">
    <table id="auction-category" class="table" style="width:100%">
        <thead class="table-light">
            <tr>
                <th>Actions</th>
                <th>Transaction Number</th>
                <th>Partner</th>
                <th>Product Purchased</th>
                <th>Auction Price</th>
                <th>Result Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td class="action-links">
                        <a href="{{ route('auction.edit', $item->id) }}"
                            class="text-decoration-none btn btn-outline-dark mb-3">Edit</a>
                        <div class="dropdown">
                            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="moreActionsDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                More
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="moreActionsDropdown">
                                <li><a class="dropdown-item" href="{{ route('auction.show', $item->id) }}"><i
                                            class="ti ti-info-circle me-1 text-black"></i>Detail</a>
                                </li>
                                <form id="formDelete" method="post" action="{{ route('post.destroy', $item->id) }}">
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
                    <td>{!! Str::limit($item->auction->product_name, 20) !!}</td>
                    <td>{!! Str::limit($item->price, 20) !!}</td>
                    <td>{!! Str::limit($item->bargain_price, 20) !!}</td>
                    <td>{!! Str::limit($item->status, 20) !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

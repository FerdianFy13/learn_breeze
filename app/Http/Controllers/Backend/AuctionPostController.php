<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AuctionPost;
use App\Models\TransactionAgency;
// use App\Models\AuctionPost;
use Illuminate\Http\Request;

class AuctionPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.auction_post.index', [
            'title' => 'Manage Post',
            'title_a' => 'Auction Post',
            'title_b' => 'Transaction Post',
            'title_c' => 'Data Post',
            'data' => TransactionAgency::with('user', 'partner', 'post')->orderBY('product_name', 'asc')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

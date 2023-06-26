<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TransactionAgency;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        $data = TransactionAgency::findOrFail($id);

        return view('pages.auction_post.v_detail_auction', [
            'title' => 'Detail Auction Post',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = TransactionAgency::findOrFail($id);

        return view('pages.auction_post.v_update_auction', [
            'title' => 'Update Auction Post',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validation = $request->validate([
                'status' => 'sometimes|required',
            ]);

            $product = TransactionAgency::findOrFail($id);
            $product->update($validation);

            if ($product) {
                return response()->json(['success' => 'Auction Post update successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to update auction post'], 500);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

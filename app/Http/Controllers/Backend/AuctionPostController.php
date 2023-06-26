<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AuctionPost;
use App\Models\TransactionAgency;
use App\Models\User;
// use App\Models\AuctionPost;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
            'data' => TransactionAgency::with('user', 'partner', 'post')->orderBY('product_name', 'asc'),
            'datas' => AuctionPost::with('user')->orderBy('product_name', 'asc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.auction_post.v_insert_datas', [
            'title' => 'Insert Datas Post',
            'data' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                'user_id' => 'required|exists:users,id',
                'product_name' => 'required|unique:products|max:255|min:3',
                'description' => 'required|max:255|min:3',
                'open_price' => [
                    'required',
                    'min:3',
                    'max:10',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
                'product_weight' => 'required|min:1|max:10|regex:/^\d+(\.\d{1,2})?$/',
                'product_quality' => 'required',
                'image' => 'required|image|file|max:4020',
            ]);

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('auction_post_images');
            }

            $product = AuctionPost::create($validation);

            if ($product) {
                return response()->json(['success' => 'Auction Post created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create auction post'], 500);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
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

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AuctionPost;
use App\Models\TransactionAgency;
use App\Models\User;
// use App\Models\AuctionPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
            'data' => TransactionAgency::with('user', 'partner', 'auction_post')->orderBY('transaction_number', 'asc')->get(),
            'transaction' => TransactionAgency::with(['user', 'partner', 'auction_post'])->orderBY('transaction_number', 'asc')->get(),
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
        $data = AuctionPost::findOrFail($id);

        return view('pages.auction_post.v_detail_datas', [
            'title' => 'Detail Datas Post',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = AuctionPost::findOrFail($id);

        return view('pages.auction_post.v_update_datas', [
            'title' => 'Detail Datas Post',
            'data' => $data,
            'user' => User::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validation = $request->validate([
                'product_name' => [
                    'sometimes', 'required', Rule::unique('auction_posts', 'product_name')->ignore($id), 'max:255', 'min:3',
                ],
                'user_id' => 'sometimes|required|exists:users,id',
                'product_name' => 'sometimes|required|unique:products|max:255|min:3',
                'description' => 'sometimes|required|max:255|min:3',
                'open_price' => [
                    'sometimes',
                    'required',
                    'min:3',
                    'max:10',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
                'product_weight' => 'sometimes|required|min:1|max:10|regex:/^\d+(\.\d{1,2})?$/',
                'product_quality' => 'sometimes|required',
                'image' => 'sometimes|required|image|file|max:4020',
            ]);

            $product = AuctionPost::findOrFail($id);
            $oldImage = $product->image;

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('auction_post_images');
            }

            $product->update($validation);

            if ($request->file('image') && $oldImage) {
                Storage::delete($oldImage); // Hapus file gambar lama
            }

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('auction_post_images');
            }

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
        $query = AuctionPost::findOrFail($id);
        $oldImage = $query->image;

        $productsCount = TransactionAgency::where('auction_post_id', $query->id)->count();
        if ($productsCount > 0) {
            return response()->json(['error' => 'Cannot delete auction post, it is still used in transaction agency'], 422);
        }

        $query->delete();

        if ($query) {
            if (!empty($oldImage) && Storage::disk('public')->exists($oldImage)) {
                Storage::delete($oldImage);
            }

            return response()->json(['success' => 'Auction Post deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Auction Post deleted failed'], 500);
        }
    }
}

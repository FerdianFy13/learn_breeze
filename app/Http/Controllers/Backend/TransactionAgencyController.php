<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AuctionPost;
use App\Models\Partner;
use App\Models\TransactionAgency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TransactionAgencyController extends Controller
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
        return view('pages.auction_post.v_insert_transaction', [
            'title' => 'Insert Transaction Post',
            'user' => User::all(),
            'post' => AuctionPost::all(),
            'partner' => Partner::all()
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
                'partner_id' => 'required|exists:partners,id',
                'auction_post_id' => 'required|exists:auction_posts,id',
                'price' => [
                    'required',
                    'min:3',
                    'max:10',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
            ]);

            $validation['image'] = 'image is still in the bidding process';
            $validation['retribution_price'] = 0.12 * $validation['price'];
            $validation['bargain_price'] = $validation['price'] + $validation['retribution_price'];
            $validation['status'] = 'Pending';
            $validation['transaction_number'] = self::generateUniqueTransactionNumber();

            $product = TransactionAgency::create($validation);

            if ($product) {
                return response()->json(['success' => 'Transaction Post created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create transaction post'], 500);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public static function generateUniqueTransactionNumber()
    {
        $randomString = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 5)), 0, 10);

        $isUnique = self::checkUniqueTransactionNumber($randomString);

        while (!$isUnique) {
            $randomString = substr(str_shuffle(str_repeat('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 5)), 0, 10);
            $isUnique = self::checkUniqueTransactionNumber($randomString);
        }

        return $randomString;
    }

    public static function checkUniqueTransactionNumber($transactionNumber)
    {
        $existingTransaction = TransactionAgency::where('transaction_number', $transactionNumber)->first();
        return !$existingTransaction;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = TransactionAgency::findOrFail($id);

        return view('pages.auction_post.v_detail_transaction', [
            'title' => 'Detail transaction Post',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = TransactionAgency::findOrFail($id);

        return view('pages.auction_post.v_update_transaction', [
            'title' => 'Update Transaction Post',
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
                return response()->json(['success' => 'Transaction Post update successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to update transaction post'], 500);
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
        $query = TransactionAgency::findOrFail($id);
        $oldImage = $query->image;

        if ($query->status == "Accepted") {
            return response()->json(['error' => 'Transaction Post cannot be deleted because it is currently accepted'], 422);
        } else  if ($query->status == "Completed") {
            return response()->json(['error' => 'Transaction Post cannot be deleted because it is currently completed'], 422);
        }

        $query->delete();

        if ($query) {
            if (!empty($oldImage) && Storage::disk('public')->exists($oldImage)) {
                Storage::delete($oldImage);
            }

            return response()->json(['success' => 'Transaction Post deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Transaction Post deleted failed'], 500);
        }
    }
}

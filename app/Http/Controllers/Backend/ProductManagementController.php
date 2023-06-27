<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductUMKM;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.product_management.index', [
            'title' => 'Product Management',
            'data' => ProductUMKM::with('user')->orderBy('title', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.product_management.insert', [
            'title' => 'Insert Product Management',
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
                'title' => 'required|unique:product_u_m_k_m_s|max:255|min:3',
                'description' => 'required|max:255|min:3',
                'price' => [
                    'required',
                    'min:3',
                    'max:10',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
                'phone_number' => [
                    'required',
                    'min:11',
                    'max:13',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
                'instagram' => 'required|url|regex:/^(https?:\/\/)?(www\.)?instagram\.com\/[a-zA-Z0-9_]+\/?$/',
                'available' => 'required',
                'image' => 'required|image|file|max:4020',
            ]);

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('product_management_images');
            }

            $partner = ProductUMKM::create($validation);

            if ($partner) {
                return response()->json(['success' => 'Product Management created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create product management'], 500);
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

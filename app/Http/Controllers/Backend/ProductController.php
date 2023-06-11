<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.product.index', [
            'title' => 'Product',
            'data' => Product::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.product.insert', [
            'title' => 'Insert Product',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                'product_name' => 'required|unique:products|max:255|min:3',
                'description' => 'required|max:255',
                'price' => 'required|min:3|max:10',
                'category' => 'required',
                'available' => 'required',
                'stock' => 'required|min:1|max:10',
                'expiration_date' => 'required',
                'weight' => 'required|min:1|max:10',
                'origin_country' => 'required|min:3|max:255',
                'image' => 'required|image|file|max:1020',
            ]);

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('product_images');
            }

            $product = Product::create($validation);

            if ($product) {
                return response()->json(['success' => 'Product created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create product'], 500);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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

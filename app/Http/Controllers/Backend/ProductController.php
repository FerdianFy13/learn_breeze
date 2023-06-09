<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
            'data' => Product::with(['category'])->orderBy('product_name', 'asc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.product.insert', [
            'title' => 'Insert Product',
            'data' => Category::all(),
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
                'description' => 'required|max:255|min:3',
                'price' => [
                    'required',
                    'min:3',
                    'max:10',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
                'category_id' => 'required|exists:categories,id',
                'available' => 'required',
                'stock' => 'required|min:1|max:10|not_in:0|regex:/^([1-9][0-9]*)$/',
                'expiration_date' => 'required',
                'weight' => 'required|min:1|max:10|not_in:0|regex:/^([1-9][0-9]*)$/',
                'origin_country' => 'required|min:3|max:255',
                'image' => 'required|image|file|max:4020',
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
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $query = Product::findOrFail($id);

        return view('pages.product.detail', [
            'title' => 'Detail Product',
            'data' => $query
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $query = Product::findOrFail($id);

        return view('pages.product.update', [
            'title' => 'Update Product',
            'data' => $query,
            'category' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validation = $request->validate([
                'product_name' => [
                    'sometimes', 'required', Rule::unique('products', 'product_name')->ignore($id), 'max:255', 'min:3',
                ],
                'description' => 'sometimes|required|max:255|min:3',
                'price' => 'sometimes|required|min:3|max:10|not_in:0|regex:/^([1-9][0-9]*)$/',
                'category_id' => 'sometimes|required|exists:categories,id',
                'available' => 'sometimes|required',
                'stock' => 'sometimes|required|min:1|max:10|not_in:0|regex:/^([1-9][0-9]*)$/',
                'expiration_date' => 'sometimes|required',
                'weight' => 'sometimes|required|min:1|max:10|not_in:0|regex:/^([1-9][0-9]*)$/',
                'origin_country' => 'sometimes|required|min:3|max:255',
                'image' => 'sometimes|required|image|file|max:4020',
            ]);

            $product = Product::findOrFail($id);
            $oldImage = $product->image;

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('product_images');
            }

            $product->update($validation);

            if ($request->file('image') && $oldImage) {
                Storage::delete($oldImage); // Hapus file gambar lama
            }

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('product_images');
            }

            if ($product) {
                return response()->json(['success' => 'Product update successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to update product'], 500);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $query = Product::findOrFail($id);
        $oldImage = $query->image;
        $query->delete();

        if ($query) {
            if (!empty($oldImage) && Storage::disk('public')->exists($oldImage)) {
                Storage::delete($oldImage);
            }

            return response()->json(['success' => 'Product deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Product deleted failed'], 500);
        }
    }
}

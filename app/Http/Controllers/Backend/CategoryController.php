<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.category.index', [
            'title' => 'Category',
            'data' => Category::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.category.insert', [
            'title' => 'Insert Category',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                'name' => 'required|unique:categories|max:255|min:3',
                'description' => 'required|max:255|min:3',
            ]);

            $category = Category::create($validation);

            if ($category) {
                return response()->json(['success' => 'Category created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create category'], 500);
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
        $category = Category::findOrFail($id);

        return view('pages.category.detail', [
            'title' => 'Detaill Category',
            'data' => $category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);

        return view('pages.category.update', [
            'title' => 'Update Category',
            'data' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validation = $request->validate([
                'name' => [
                    'sometimes', 'required', Rule::unique('categories', 'name')->ignore($id), 'max:255', 'min:3',
                ],
                'description' => 'sometimes|required|max:255|min:3',
            ]);

            $category = Category::findOrFail($id);
            $category->update($validation);

            if ($category) {
                return response()->json(['success' => 'Category updated successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to updated category'], 500);
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
        $category = Category::findOrFail($id);

        $productsCount = Product::where('category_id', $category->id)->count();
        if ($productsCount > 0) {
            return response()->json(['error' => 'Cannot delete category, it is still used in products'], 422);
        }

        $query = $category->delete();

        if ($query) {
            return response()->json(['success' => 'Category deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Category deleted failed'], 500);
        }
    }
}

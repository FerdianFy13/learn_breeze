<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class LogoManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.logo_management.index', [
            'title' => 'Logo Management',
            'data' => Logo::with('partner')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.logo_management.insert', [
            'title' => 'Logo Management',
            'data' => Partner::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                'name' => 'required|unique:logos|max:255|min:3',
                'partner_id' => 'required|exists:partners,id|unique:logos',
                'image' => 'required|image|file|max:2020',
            ]);

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('logo_images');
            }

            $product = Logo::create($validation);

            if ($product) {
                return response()->json(['success' => 'Logo created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create logo'], 500);
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
        $data = Logo::findOrFail($id);

        return view('pages.logo_management.detail', [
            'title' => 'Detail Logo Management',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Logo::findOrFail($id);

        return view('pages.logo_management.update', [
            'title' => 'Update Logo Management',
            'data' => $data,
            'query' => Partner::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validation = $request->validate([
                'name' => [
                    'sometimes', 'required', Rule::unique('logos', 'name')->ignore($id), 'max:255', 'min:3',
                ],
                'partner_id' => [
                    'sometimes', 'required', Rule::unique('logos', 'partner_id')->ignore($id), 'exists:partners,id',
                ],
                'image' => 'sometimes|required|image|file|max:4020',
            ]);

            $logo = Logo::findOrFail($id);
            $oldImage = $logo->image;

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('logo_images');
            }

            $logo->update($validation);

            if ($request->file('image') && $oldImage) {
                Storage::delete($oldImage); // Hapus file gambar lama
            }

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('logo_images');
            }

            if ($logo) {
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
    public function destroy(string $id)
    {
        $query = Logo::findOrFail($id);
        $oldImage = $query->image;
        $query->delete();

        if ($query) {
            if (!empty($oldImage) && Storage::disk('public')->exists($oldImage)) {
                Storage::delete($oldImage);
            }

            return response()->json(['success' => 'Logo deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Logo deleted failed'], 500);
        }
    }
}

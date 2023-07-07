<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InformationManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.information_manage.index', [
            'title' => 'Information Management',
            'data' => Information::with('user')->orderBy('title', 'asc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.information_manage.insert', [
            'title' => 'Insert Information Management',
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
                // 'user_id' => 'required|exists:users,id',
                'title' => 'required|unique:information|max:255|min:3',
                'description' => 'required|max:255|min:3',
                'available' => 'required',
                'image' => 'required|image|file|max:4020',
            ]);

            $validation['user_id'] = Auth::id();

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('information_management_images');
            }

            $partner = Information::create($validation);

            if ($partner) {
                return response()->json(['success' => 'Information Management created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create information management'], 500);
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
        $data = Information::findOrFail($id);

        return view('pages.information_manage.detail', [
            'title' => 'Detail Information Management',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Information::findOrFail($id);

        return view('pages.information_manage.update', [
            'title' => 'Update Information Management',
            'data' => $data,
            'user' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validation = $request->validate([
                // 'user_id' => 'sometimes|required|exists:users,id',
                'title' => [
                    'sometimes', 'required', Rule::unique('information', 'title')->ignore($id), 'max:255', 'min:3',
                ],
                'description' => 'sometimes|required|max:255|min:3',
                'available' => 'sometimes|required',
                'image' => 'sometimes|required|image|file|max:4020',
            ]);

            $validation['user_id'] = Auth::id();

            $product = Information::findOrFail($id);
            $oldImage = $product->image;

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('information_management_images');
            }

            $product->update($validation);

            if ($request->file('image') && $oldImage) {
                Storage::delete($oldImage); // Hapus file gambar lama
            }

            if ($request->file('image')) {
                $validation['image'] = $request
                    ->file('image')
                    ->store('information_management_images');
            }

            if ($product) {
                return response()->json(['success' => 'Information Management updated successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to updated information management'], 500);
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
        $query = Information::findOrFail($id);
        $oldImage = $query->image;

        if ($query->available == "Enabled") {
            return response()->json(['error' => 'Information management cannot be deleted because it is currently enabled'], 422);
        }

        $query->delete();

        if ($query) {
            if (!empty($oldImage) && Storage::disk('public')->exists($oldImage)) {
                Storage::delete($oldImage);
            }

            return response()->json(['success' => 'Information management deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Information management deleted failed'], 500);
        }
    }
}

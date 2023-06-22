<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\Partner;
use Illuminate\Http\Request;
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
                'partner_id' => 'required|exists:partners,id',
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

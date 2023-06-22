<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PartnerManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.partner_management.index', [
            'title' => 'Partner Management',
            'data' => Partner::with('user')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.partner_management.insert', [
            'title' => 'Insert Partner Management',
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
                'person_responsible' => 'required|unique:partners|max:255|min:3',
                'address' => 'required|max:255|min:3',
                'available' => 'required',
                'phone_number' => [
                    'required',
                    'min:11',
                    'max:13',
                ],
                'user_id' => 'required|exists:users,id|unique:partners',
                'business_type' => 'required|max:255|min:3',
            ]);

            $partner = Partner::create($validation);

            if ($partner) {
                return response()->json(['success' => 'Partner created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create partner'], 500);
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
        $data = Partner::findOrFail($id);

        return view('pages.partner_management.detail', [
            'title' => 'Detaill Partner Management',
            'data' => $data,
        ]);
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

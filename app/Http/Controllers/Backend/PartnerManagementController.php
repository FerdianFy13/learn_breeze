<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\Partner;
use App\Models\TransactionAgency;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
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
            'title' => 'Detail Partner Management',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Partner::findOrFail($id);

        return view('pages.partner_management.update', [
            'title' => 'Update Partner Management',
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
                'person_responsible' => [
                    'sometimes', 'required', Rule::unique('partners', 'person_responsible')->ignore($id), 'max:255', 'min:3',
                ],
                'address' => 'sometimes|required|max:255|min:3',
                'available' => 'required',
                'phone_number' => [
                    'required',
                    'min:11',
                    'max:13',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
                'user_id' => [
                    'sometimes', 'required', Rule::unique('partners', 'user_id')->ignore($id), 'exists:users,id',
                ],
                'business_type' => 'sometimes|required|max:255|min:3',
            ]);

            $partner = Partner::findOrFail($id);
            $partner->update($validation);

            if ($partner) {
                return response()->json(['success' => 'Partner updated successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to updated partner'], 500);
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
        $data = Partner::findOrFail($id);
        $logoCount = Logo::where('partner_id', $data->id)->count();
        $transaction = TransactionAgency::where('partner_id', $data->id)->count();

        if ($data->available == "Enabled") {
            return response()->json(['error' => 'Partner cannot be deleted because it is currently enabled'], 422);
        } else if ($logoCount > 0) {
            return response()->json(['error' => 'Cannot delete partner, it is still used in logo'], 419);
        } else if ($transaction > 0) {
            return response()->json(['error' => 'Cannot delete partner, it is still used in logo'], 419);
        }

        $query = $data->delete();

        if ($query) {
            return response()->json(['success' => 'Partner deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Partner deleted failed'], 500);
        }
    }
}

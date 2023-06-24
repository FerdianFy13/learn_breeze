<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Fisherman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FishermanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.fisherman_manage.index', [
            'title' => 'Manage Fisherman',
            'data' => Fisherman::with('user')->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.fisherman_manage.insert', [
            'title' => 'Insert Manage Fisherman',
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
                'name' => 'required|unique:fishermen|max:255|min:3',
                'ship_name' => 'required|max:255|min:3',
                'ship_owner' => 'required|max:255|min:3',
                'type_ship' => 'required|max:255|min:3',
                'available' => 'required',
                'phone_number' => [
                    'required',
                    'min:11',
                    'max:13',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
                'result_member' => [
                    'required',
                    'min:1',
                    'max:13',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
                'user_id' => 'required|exists:users,id|unique:fishermen',
            ]);

            $partner = Fisherman::create($validation);

            if ($partner) {
                return response()->json(['success' => 'Fisherman created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create fisherman'], 500);
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
        $data = Fisherman::findOrFail($id);

        return view('pages.fisherman_manage.detail', [
            'title' => 'Detail Manage Fisherman',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Fisherman::findOrFail($id);

        return view('pages.fisherman_manage.update', [
            'title' => 'Update Manage Fisherman',
            'data' => $data,
            'query' => User::all(),
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
                    'sometimes', 'required', Rule::unique('fishermen', 'name')->ignore($id), 'min:3',
                    'max:255',
                ],
                'ship_name' => 'sometimes|required|max:255|min:3',
                'ship_owner' => 'sometimes|required|max:255|min:3',
                'type_ship' => 'sometimes|required|max:255|min:3',
                'available' => 'sometimes|sometimes|required',
                'phone_number' => [
                    'sometimes',
                    'required',
                    'min:11',
                    'max:13',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
                'result_member' => [
                    'sometimes',
                    'required',
                    'min:1',
                    'max:13',
                    'not_in:0',
                    'regex:/^([1-9][0-9]*)$/'
                ],
                'user_id' => [
                    'sometimes', 'required', Rule::unique('fishermen', 'user_id')->ignore($id), 'exists:users,id',
                ],
            ]);

            $fish = Fisherman::findOrFail($id);
            $fish->update($validation);

            if ($fish) {
                return response()->json(['success' => 'Fisherman updated successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to updated fisherman'], 500);
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
        $data = Fisherman::findOrFail($id);

        if ($data->available == "Enabled") {
            return response()->json(['error' => 'Fisherman cannot be deleted because it is currently enabled'], 422);
        }

        $query = $data->delete();

        if ($query) {
            return response()->json(['success' => 'Fisherman deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Fisherman deleted failed'], 500);
        }
    }
}

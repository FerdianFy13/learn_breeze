<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class UserManagemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.user_management.index', [
            'title' => 'User Management',
            'data' => User::with('role')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('pages.user_management.detail', [
            'title' => 'Detail User Management',
            'data' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $role = Role::all();

        return view('pages.user_management.update', [
            'title' => 'Update User Management',
            'data' => $user,
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validation = $request->validate([
                'name' => 'nullable',
                'email' => 'nullable',
                'password' => 'nullable',
                'status_id' => 'sometimes|required|exists:statuses,id',
            ]);

            $role = User::find($id);
            $role->update($validation);

            if ($role) {
                return response()->json(['success' => 'Status user updated successfully'], 200);
            } else {
                return response()->json(['error' => 'Failed to update status user'], 500);
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
        //
    }

    public function edituser(string $id)
    {
        $user = User::findOrFail($id);
        $role = Role::all();

        return view('pages.user_management.update_user', [
            'title' => 'Update Role User Management',
            'data' => $user,
            'role' => $role,
        ]);
    }


    public function updateuser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $roleName = $request->input('role');
            $role = Role::where('name', $roleName)->first();
            $data = $user->syncRole([$role]);

            if ($data) {
                return response()->json(['success' => 'Role user updated successfully'], 200);
            } else {
                return response()->json(['error' => 'Failed to update rolle user'], 500);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}

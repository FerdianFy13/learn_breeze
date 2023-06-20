<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.role_management.index', [
            'title' => 'Role Management',
            'permission' => Permission::orderBy('name', 'asc')->get(),
            'data' => Role::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.role_management.insert', [
            'title' => 'Insert Role Management',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                'name' => 'required|unique:roles|max:255|min:3',
            ]);

            $role = Role::create($validation);

            if ($role) {
                return response()->json(['success' => 'Role created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create Role'], 500);
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
        $role = Role::findOrFail($id);


        return view('pages.role_management.detail', [
            'title' => 'Detail Role Management',
            'data' => $role,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);


        return view('pages.role_management.update_role', [
            'title' => 'Update Role Management',
            'data' => $role,
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
                    'sometimes', 'required', Rule::unique('roles', 'name')->ignore($id), 'max:255', 'min:3',
                ],
            ]);

            $role = Role::findOrFail($id);

            $modelHasPermissionsCount = DB::table('model_has_roles')
                ->where('role_id', $role->id)
                ->count();

            if ($modelHasPermissionsCount > 0) {
                return response()->json(['error' => 'Cannot update role, it is still used in model_has_roles'], 419);
            }

            $role->update($validation);

            if ($role) {
                return response()->json(['success' => 'Role updated successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to updated Role'], 500);
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
        $role = Role::findOrFail($id);

        $modelHasPermissionsCount = DB::table('model_has_roles')
            ->where('role_id', $role->id)
            ->count();

        if ($modelHasPermissionsCount > 0) {
            return response()->json(['error' => 'Cannot update role, it is still used in model_has_roles'], 422);
        }

        $query = $role->delete();

        if ($query) {
            return response()->json(['success' => 'Role deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Role deleted failed'], 500);
        }
    }
}

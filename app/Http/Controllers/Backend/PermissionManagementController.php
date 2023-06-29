<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;

class PermissionManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.permission_management.index', [
            'title' => 'Permission Management',
            'data' => Permission::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.permission_management.insert', [
            'title' => 'Insert Permission Management',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                'name' => 'required|unique:permissions|max:255|min:3',
            ]);

            $category = Permission::create($validation);

            if ($category) {
                return response()->json(['success' => 'Permission created successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to create Permission'], 500);
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
        $permission = Permission::findOrFail($id);

        return view('pages.permission_management.detail', [
            'title' => 'Detail Permission Management',
            'data' => $permission,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('pages.permission_management.update', [
            'title' => 'Update Permission Management',
            'data' => $permission,
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
                    'sometimes', 'required', Rule::unique('permissions', 'name')->ignore($id), 'max:255', 'min:3',
                ],
            ]);

            $permission = Permission::findOrFail($id);

            $modelHasPermissionsCount = DB::table('model_has_permissions')
                ->where('permission_id', $permission->id)
                ->count();

            if ($modelHasPermissionsCount > 0) {
                return response()->json(['error' => 'Cannot update permission, it is still used in model_has_permissions'], 419);
            }

            $permission->update($validation);

            if ($permission) {
                return response()->json(['success' => 'Permission updated successfully'], 201);
            } else {
                return response()->json(['error' => 'Failed to updated Permission'], 500);
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
        $permission = Permission::findOrFail($id);

        $modelHasPermissionsCount = DB::table('model_has_permissions')
            ->where('permission_id', $permission->id)
            ->count();

        if ($modelHasPermissionsCount > 0) {
            return response()->json(['error' => 'Cannot delete permission, it is still used in model_has_permissions'], 422);
        }

        $query = $permission->delete();

        if ($query) {
            return response()->json(['success' => 'Permission deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'Permission deleted failed'], 500);
        }
    }
}

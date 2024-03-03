<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use App\Models\RolesPermission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rolesWithPermissions = Role::with('roleHasPermissions.permission')->get();
        // return $rolesWithPermissions;
        // Group the permissions by role_id
        // $groupedRoles = $rolesWithPermissions->groupBy('id');

        // return $groupedRoles;
        return view('admin.roles-permission.list', [
            'roles_permissions' => $rolesWithPermissions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return Permission::all()->groupBy('group_name');
        return view('admin.roles-permission.create', [
            'roles' => Role::all(),
            'permissions' => Permission::all()->groupBy('group_name'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        foreach ($request->permission_id as $permission_id) {
            $rolepermission = RolesPermission::create([
                'permission_id' => $permission_id,
                'role_id' => $request->role_id,
            ]);
        }
        //clearing the cache or the role will not have the permissions
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return back()->with('message', 'Role Permissions Assign Successfully!');

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $roles_permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $roles_permission)
    {
        $role_id = $roles_permission;
        $roles_permission = RolesPermission::where('role_id', $roles_permission)->get();
        return view('admin.roles-permission.edit', [
            'roles_permission' => $roles_permission,
            'role_id' => $role_id,
            'roles' => Role::all(),
            'permissions' => Permission::all()->groupBy('group_name'),
        ]);
        // return $permissions;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $roles_permission)
    {
        $delete = RolesPermission::where('role_id', $roles_permission)->delete();
        foreach ($request->permission_id as $permission_id) {
            $rolepermission = RolesPermission::create([
                'permission_id' => $permission_id,
                'role_id' => $roles_permission,
            ]);
        }

        //clearing the cache or the role will not have the permissions
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->route('roles-permission.index')->with('message', 'Role Permissions Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $roles_permission)
    {
        $delete = RolesPermission::where('role_id', $roles_permission)->delete();
        return redirect()->route('roles-permission.index')->with('message', 'Role Permissions Deleted Successfully!');
    }
}

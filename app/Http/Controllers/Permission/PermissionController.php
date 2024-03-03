<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return  Permission::all();
        return view(
            'admin.permission.list',
            [
                // 'permissions' => Permission::all()->groupBy('group_name'),
                'permissions' => Permission::all(),
            ]
        );
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'name' => 'required',
            'group_name' => 'required'
        ]);
        // Replace this with your actual string variable
        // Remove spaces and convert to lowercase
        $group_name = str_replace(' ', '_', strtolower($request->group_name));
        $operations = ['view', 'add', 'edit', 'delete', 'approve'];

        foreach ($operations as $operation) {
            $permission_name = $group_name . '.' . $operation;

            $permission = Permission::create([
                'name' => $permission_name,
                'group_name' => $group_name,
            ]);
            // echo $permission_name . '<br>';
        }
        return back()->with('message', 'Permission Added Successfully!');
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
    public function edit(Permission $id)
    {
        // return $id;

        return view(
            'admin.permission.edit',
            [
                'permission' => $id,
            ]
        );
        // return $permissions;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $id)
    {
        $request->validate([
            'name' => 'required',
            'group_name' => 'required'
        ]);

        $id->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);
        return redirect()->route('permission.index')->with('message', 'Permission Updated Successfully!');
        // return redirect back()->with('message', 'Permission Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $id)
    {
        $permissions = $id->delete();
        return back()->with('message', 'Permission Deleted Successfully!');
    }
}

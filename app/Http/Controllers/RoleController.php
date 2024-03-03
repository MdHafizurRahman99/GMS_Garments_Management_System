<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.role.list', [
            'roles' => Role::all(),
        ]);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $role = Role::create(['name' => $request->name,]);

        return back()->with('message', 'Role Added Successfully!');

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // return $role;
        return view('admin.role.edit', [
            'role' => $role,
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $role->update([
            'name' => $request->name,
        ]);
        return redirect()->route('role.index')->with('message', 'Role Updated Successfully');
        // return $request;
        // return $role;
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role = $role->delete();
        return back()->with('message', 'Role Deleted Successfully!');
    }
}

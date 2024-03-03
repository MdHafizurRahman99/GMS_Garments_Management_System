<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.admin.list', [
            'admins' => User::where('role', 'admin')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.admin.create', [
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class, 'regex:/[^\s@]+@[^\s@]+\.[a-zA-Z]{2,6}/',],
        ], [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'email.regex' => 'The :attribute must be in a valid email format.',
            'min' => 'The :attribute must be at least :min characters.',
            'confirmed' => 'The :attribute and Confirm Password dont match.',
            'unique' => 'This :attribute is already registered',

        ]);
        $validator->setAttributeNames([
            'name' => 'Admin Name',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirmation' => 'Confirm Password',
        ]);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 400);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // return $request;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);

        $user->sendEmailVerificationNotification();

        if ($request->roles) {
            # code...
            $user->assignRole($request->roles);
        }

        return back()->with('message', 'Admin Added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $id)
    {
        // return $id;

        return view('admin.admin.edit', [
            'roles' => Role::all(),
            'admin' => $id,
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $id)
    {
        // return $request->roles;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'regex:/[^\s@]+@[^\s@]+\.[a-zA-Z]{2,6}/',],
        ], [
            'required' => 'The :attribute field is required.',
            'email' => 'The :attribute must be a valid email address.',
            'email.regex' => 'The :attribute must be in a valid email format.',
            'min' => 'The :attribute must be at least :min characters.',
            'confirmed' => 'The :attribute and Confirm Password dont match.',
            'unique' => 'This :attribute is already registered',
        ]);
        $validator->setAttributeNames([
            'name' => 'Admin Name',
            'email' => 'Email',
        ]);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 400);
            return redirect()->back()->withErrors($validator)->withInput();
        }        //
        $user = $id;

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'admin'
        ]);
        //removing previous roles
        $user->roles()->detach();
        //adding new roles
        if ($request->roles) {
            # code...
            $user->assignRole($request->roles);
        }
        return redirect()->route('admin.index')->with('message', 'Admin Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $id)
    {
        $id->delete();
        return redirect()->route('admin.index')->with('message', 'Admin Deleted Successfully!');


        //
    }
}
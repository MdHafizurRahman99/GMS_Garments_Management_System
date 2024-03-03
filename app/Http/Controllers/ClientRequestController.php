<?php

namespace App\Http\Controllers;

use App\Models\ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewClient;

class ClientRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'admin.onboarding-request.list',
            ['requests' => ClientRequest::all(),]
        );
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.onboarding-request.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(), [

            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => ['required', 'regex:/^[0-9\s()-]+$/', 'min:7', 'max:20',],
            'email' => ['required', 'regex:/[^\s@]+@[^\s@]+\.[a-zA-Z]{2,6}/',],

        ], [
            'required' => ' :attribute field is required.',
            'phone.regex' => ' :attribute format is invalid.',
            'email' => ' :attribute must be a valid email address.',
            'email.regex' => ' :attribute must be in a valid email format.',
        ]);

        $validator->setAttributeNames([
            'phone' => 'Phone',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email'
        ]);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $phoneNumber = '+' . $request->phone_country_dial_code . '  ' . $request->phone;
        $clientRequest = ClientRequest::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $phoneNumber,
            'email' => $request->email,
        ]);
        //it will send mail to $request->email
        //need to send to all accountant
        // Mail::to($request->email)->send(new NewClient($request));

        return back()->with('message', 'Onboarding request added Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientRequest $clientRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientRequest $clientRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClientRequest $clientRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientRequest $clientRequest)
    {
        //
    }
}
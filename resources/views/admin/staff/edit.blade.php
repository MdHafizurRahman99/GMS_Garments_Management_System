@extends('layouts.admin.master')

@section('title')
    Edit Staff Details
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/wizard copy.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">

    {{-- for abn start --}}
    <script src="{{ asset('js/abn/json.js') }}"></script>
    <script src="{{ asset('js/abnlookup-sample.js') }}"></script>
    {{-- for abn end --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <style>
        .thumbnail {
            width: 100px;
            /* Adjust size as needed */
            height: auto;
            /* Adjust size as needed */
            cursor: pointer;
        }



        .image-container {
            text-align: center;
            /* Center the image horizontally */
            margin-bottom: 20px;
            /* Example margin, adjust as needed */
        }

        .full-width-image {
            width: 100%;
            /* Occupy the full width of the container */
            height: auto;
            /* Maintain aspect ratio */
        }
    </style>
@endsection

@section('content')
    <section class="signup-step-container ">
        <div class="container border pt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="wizard">
                        <div class="wizard-inner">
                            <div class="connecting-line"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab"
                                        aria-expanded="true"><span class="round-tab">1 </span> <i>Step 1</i></a>
                                </li>
                                {{-- <li role="presentation" class="disabled">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"
                                        aria-expanded="false"><span class="round-tab">2</span> <i>Step 2</i></a>
                                </li> --}}
                                <li role="presentation" class="disabled">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span
                                            class="round-tab">2</span> <i>Step 2</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span
                                            class="round-tab">3</span> <i>Step 3</i></a>
                                </li>
                            </ul>
                        </div>
                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ 'There is invalid information in Form Data' }}
                            </div>
                        @endif

                        <form role="form" action="{{ route('staff.update', ['id' => $staff->id]) }}" class="login-box"
                            method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" value="{{ old('abn_entity_name') }}" name="abn_entity_name">
                            <input type="hidden" value="{{ old('abn_address') }}" name="abn_address">
                            <input type="hidden" value="{{ old('abn_status') }}" name="abn_status">
                            <input type="hidden" value="{{ old('abn_business_name') }}" name="abn_business_name">

                            <div class="tab-content" id="main_form">
                                <div class="tab-pane active" role="tabpanel" id="step1">
                                    <h4 class="text-center">Employee or Contractor Details </h4>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name">First Name *</label>
                                                <input type="text" id="first_name" name="first_name"
                                                    value="{{ old('first_name', $staff->first_name ?? '') }}"
                                                    class="form-control" placeholder="First Name">
                                                @error('first_name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name*</label>
                                                <input type="text" id="last_name" name="last_name"
                                                    value="{{ old('last_name', $staff->last_name ?? '') }}"
                                                    class="form-control" placeholder="Last Name">
                                                @error('last_name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input class="form-control" type="date" name="start_date"
                                                    value="{{ old('start_date', $staff->start_date ?? '') }}"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Possion Title</label>
                                                <input class="form-control" type="text"
                                                    value="{{ old('possion_title', $staff->possion_title ?? '') }}"
                                                    name="possion_title" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                            value="Male"
                                                            {{ old('gender', $staff->gender) == 'Male' ? 'checked' : '' }}>Male
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                            value="Female"
                                                            {{ old('gender', $staff->gender) == 'Female' ? 'checked' : '' }}>Female
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input class="form-control" type="date" name="date_of_birth"
                                                    value="{{ old('date_of_birth', $staff->date_of_birth ?? '') }}"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input class="form-control" type="text" name="address"
                                                    value="{{ old('address', $staff->address ?? '') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Suburb</label>
                                                <input class="form-control" type="text" name="suburb"
                                                    value="{{ old('suburb', $staff->suburb ?? '') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input class="form-control" type="text" name="state"
                                                    value="{{ old('state', $staff->state ?? '') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postcode</label>
                                                <input class="form-control" type="text" name="postcode"
                                                    value="{{ old('postcode', $staff->postcode ?? '') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Home Phone</label>
                                                <input type="hidden" value="{{ old('phone_country_dial_code') }}"
                                                    id="phone_country_dial_code" name="phone_country_dial_code">
                                                <input type="hidden" value="{{ old('phone_iso2') }}" id="phone_iso2"
                                                    name="phone_iso2">
                                                <input type="tel" id="phone" name="phone"
                                                    value="{{ old('phone', $staff->phone ?? '') }}" class="form-control"
                                                    placeholder="">
                                                @error('phone')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="work">Mobile Number</label>
                                                <input type="hidden" value="{{ old('mobile_country_dialCode') }}"
                                                    id="mobile_country_dialCode" name="mobile_country_dialCode">
                                                <input type="hidden" value="{{ old('mobile_iso2') }}" id="mobile_iso2"
                                                    name="mobile_iso2">
                                                <input type="tel" id="mobile" name="mobile"
                                                    value="{{ old('mobile', $staff->mobile ?? '') }}"
                                                    class="form-control" placeholder="">
                                                @error('mobile')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" type="email" name="email"
                                                    value="{{ old('email', $staff->email ?? '') }}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="super_fund">Existing super fund (if any)</label>
                                                <input type="text" id="super_fund" name="super_fund"
                                                    value="{{ old('super_fund', $staff->super_fund ?? '') }}"
                                                    class="form-control" placeholder="">
                                                @error('super_fund')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="member_no">Member No </label>
                                                <input type="text" id="member_no" name="member_no"
                                                    value="{{ old('member_no', $staff->member_no ?? '') }}"
                                                    class="form-control" placeholder="">
                                                @error('member_no')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="employee_type">Employee Type</label>
                                                <select id="employee_type" name="employee_type" class="form-control">
                                                    <option value="full_time" {{ old('employee_type', $staff->employee_type ?? '') == 'full_time' ? 'selected' : '' }}>Full Time</option>
                                                    <option value="part_time" {{ old('employee_type', $staff->employee_type ?? '') == 'part_time' ? 'selected' : '' }}>Part Time</option>
                                                    <option value="casual" {{ old('employee_type', $staff->employee_type ?? '') == 'casual' ? 'selected' : '' }}>Casual</option>
                                                </select>
                                                @error('employee_type')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="employee_tax_file">Employee Tax File</label>
                                                <input type="text" id="employee_tax_file" name="employee_tax_file"
                                                    value="{{ old('employee_tax_file', $staff->employee_tax_file ?? '') }}"
                                                    class="form-control" placeholder="">
                                                @error('employee_tax_file')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Are you an Contractor? </label>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="contractor"
                                                    value="Yes"
                                                    {{ old('contractor', $staff->contractor) == 'Yes' ? 'checked' : '' }}>Yes
                                                &emsp;
                                                <input type="radio" class="form-check-input" name="contractor"
                                                    value="No"
                                                    {{ old('contractor', $staff->contractor) == 'No' ? 'checked' : '' }}>No
                                            </label>
                                        </div>
                                        <label>If yes: </label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Company Name</label>
                                                    <input class="form-control" type="text" name="company_name"
                                                        value="{{ old('company_name', $staff->company_name ?? '') }}"
                                                        placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Company Address</label>
                                                    <input class="form-control" type="text" name="company_address"
                                                        value="{{ old('company_address', $staff->company_address ?? '') }}"
                                                        placeholder="">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Company Phone Number</label>
                                                    <input type="hidden"
                                                        value="{{ old('company_phone_country_dialCode') }}"
                                                        id="company_phone_country_dialCode"
                                                        name="company_phone_country_dialCode">
                                                    <input type="hidden" value="{{ old('company_phone_iso2') }}"
                                                        id="company_phone_iso2" name="company_phone_iso2">
                                                    <input class="form-control" type="text" id="company_phone"
                                                        value="{{ old('company_phone', $staff->company_phone ?? '') }}"
                                                        name="company_phone" placeholder="">
                                                    @error('company_phone')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Company Email</label>
                                                    <input class="form-control" type="email" name="company_email"
                                                        value="{{ old('company_email', $staff->company_email ?? '') }}"
                                                        placeholder="">
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="business_number">Australian Business Number(ABN)</label>
                                                    <input  type="text" id="business_number"
                                                        name="business_number"
                                                        value="{{ old('business_number', $staff->business_number ?? '') }}"
                                                        class="form-control" placeholder="">
                                                    @error('business_number')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div> --}}


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="old_abn_entity_name">Entity Name</label>
                                                    <input disabled type="text" id="old_abn_entity_name"
                                                        name="old_abn_entity_name" class="form-control"
                                                        value="{{ old('old_abn_entity_name', $staff->abn_entity_name ?? '') }}">
                                                    @error('old_abn_entity_name')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="old_abn_status">ABN status</label>
                                                    <input disabled type="text" id="old_abn_status"
                                                        name="old_abn_status" class="form-control"
                                                        value="{{ old('old_abn_status', $staff->abn_status ?? '') }}">
                                                    @error('old_abn_status')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="old_abn_business_name">Business name</label>
                                                    <input disabled type="text" id="old_abn_business_name"
                                                        name="old_abn_business_name" class="form-control"
                                                        value="{{ old('old_abn_business_name', $staff->abn_business_name ?? '') }}">
                                                    @error('old_abn_business_name')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="abn_address">Address</label>
                                                    <input disabled type="text" id="abn_address" name="abn_address"
                                                        class="form-control"
                                                        value="{{ old('abn_address', $staff->abn_address ?? '') }}">
                                                    @error('abn_address')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="business_number">Australian Business Number(ABN)</label>
                                                    <input name="TextBoxGuid" type="hidden"
                                                        value="1d25add7-1327-4ed6-bd85-d8318553340e" id="TextBoxGuid" />

                                                    <input type="text" id="TextBoxAbn" name="business_number"
                                                        value="{{ old('business_number', $staff->business_number ?? '') }}"
                                                        class="form-control" placeholder="">

                                                    <input type="button" name="ButtonAbnLookup" value="ABN Lookup"
                                                        id="ButtonAbnLookup"
                                                        onclick="abnLookup('TextBoxAbn','TextBoxGuid');"
                                                        class="form-control btn-primary mt-2  " />
                                                    {{-- <label style="display: none;" id="EntityNameLabel">Entity Name</label>
                                                    <input style="display: none;" class="form-control" type="text"
                                                        size="100" id="TextBoxEntityName" value="" />
                                                    <label style="display: none;" id="AbnStatusLabel">ABN status:</label>
                                                    <input style="display: none;" class="form-control" type="text"
                                                        size="50" id="TextBoxAbnStatus" value="" />
                                                    <label style="display: none;" id="AddressLabel">Address: </label>
                                                    <input style="display: none;" class="form-control" type="text"
                                                        size="10" id="TextBoxAddressState" value="" />,
                                                    <input style="display: none;" class="form-control" type="text"
                                                        size="10" id="TextBoxAddressPostcode" value="" />
                                                    <input type="button" style="display: none;" name="ButtonHide"
                                                        value="Hide" id="ButtonHide" onclick="hideFields()"
                                                        class="form-control btn-secondary mt-2" /> --}}
                                                    @error('business_number')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company_number">Australian Company Number(ACN)</label>
                                                    <input type="text" id="company_number" name="company_number"
                                                        value="{{ old('company_number', $staff->company_number ?? '') }}"
                                                        class="form-control" placeholder="">
                                                    @error('company_number')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>



                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn next-step"
                                                style="color: white;">Continue to next
                                                step</button></li>
                                    </ul>
                                </div>
                                {{-- <div class="tab-pane" role="tabpanel" id="step2">
                                    <h4 class="text-center">Details for contractors</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input class="form-control" type="text" name="company_name"
                                                    value="{{ old('company_name', $staff->company_name ?? '') }}"
                                                    placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Company Address</label>
                                                <input class="form-control" type="text" name="company_address"
                                                    value="{{ old('company_address', $staff->company_address ?? '') }}"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Company Phone Number</label>
                                                <input type="hidden" value="{{ old('company_phone_country_dialCode') }}"
                                                    id="company_phone_country_dialCode"
                                                    name="company_phone_country_dialCode">
                                                <input type="hidden" value="{{ old('company_phone_iso2') }}"
                                                    id="company_phone_iso2" name="company_phone_iso2">
                                                <input class="form-control" type="text" id="company_phone"
                                                    value="{{ old('company_phone', $staff->company_phone ?? '') }}"
                                                    name="company_phone" placeholder="">
                                                @error('company_phone')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Company Email</label>
                                                <input class="form-control" type="email" name="company_email"
                                                    value="{{ old('company_email', $staff->company_email ?? '') }}"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="business_number">Australian Business Number(ABN)</label>
                                                <input name="TextBoxGuid" type="hidden"
                                                    value="1d25add7-1327-4ed6-bd85-d8318553340e" id="TextBoxGuid" />

                                                <input  type="text" id="TextBoxAbn" name="business_number"
                                                    value="{{ old('business_number', $staff->business_number ?? '') }}"
                                                    class="form-control" placeholder="">

                                                <input type="button" name="ButtonAbnLookup" value="ABN Lookup"
                                                    id="ButtonAbnLookup" onclick="abnLookup('TextBoxAbn','TextBoxGuid');"
                                                    class="form-control btn-primary mt-2  " />

                                                @error('business_number')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_number">Australian Company Number(ACN)</label>
                                                <input  type="text" id="company_number" name="company_number"
                                                    value="{{ old('company_number', $staff->company_number ?? '') }}"
                                                    class="form-control" placeholder="">
                                                @error('company_number')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>


                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn prev-step">Back</button></li>
                                        <li><button type="button" class="default-btn next-step">Continue</button></li>
                                    </ul>
                                </div> --}}
                                <div class="tab-pane" role="tabpanel" id="step3">
                                    <h4 class="text-center">Bank Details </h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bank Name</label>
                                                <input class="form-control" type="text" name="bank_name"
                                                    value="{{ old('bank_name', $staff->bank_name ?? '') }}"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="bsb_number">BSB Number</label>
                                                <input type="text" id="bsb_number" name="bsb_number"
                                                    class="form-control"
                                                    value="{{ old('bsb_number', $staff->bsb_number ?? '') }}"
                                                    placeholder="Enter BSB Number">
                                                @error('bsb_number')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Account Name</label>
                                                <input class="form-control" type="text" name="account_name"
                                                    value="{{ old('account_name', $staff->account_name ?? '') }}"
                                                    placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="account_number">Account Number</label>
                                                <input type="text" id="account_number" name="account_number"
                                                    value="{{ old('account_number', $staff->account_number ?? '') }}"
                                                    class="form-control" placeholder="Enter Account Number">
                                                @error('account_number')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn prev-step">Back</button></li>

                                        <li><button type="button" class="default-btn next-step"
                                                style="color: white;">Continue</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step4">
                                    <h4 class="text-center">Additional Information</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Are you an Australian citizen? </label>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="aus_citizen"
                                                            value="Yes"
                                                            {{ old('aus_citizen', $staff->aus_citizen) == 'Yes' ? 'checked' : '' }}>Yes
                                                        &emsp;
                                                        <input type="radio" class="form-check-input" name="aus_citizen"
                                                            value="No"
                                                            {{ old('aus_citizen', $staff->aus_citizen) == 'No' ? 'checked' : '' }}>No
                                                    </label>
                                                </div>

                                                <label>If no, </label>
                                                <br>
                                                <div class="col-md-6">

                                                    <label>- Are you a permanent resident? </label>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="permanent_resident" value="Yes"
                                                                {{ old('permanent_resident', $staff->permanent_resident) == 'Yes' ? 'checked' : '' }}>Yes
                                                            &emsp;
                                                            <input type="radio" class="form-check-input"
                                                                name="permanent_resident" value="No"
                                                                {{ old('permanent_resident', $staff->permanent_resident) == 'No' ? 'checked' : '' }}>No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="visa_expiry_date">- Do you have a Working Visa? Expiry
                                                        date:
                                                    </label>

                                                    <input class="form-control" type="date" id="visa_expiry_date"
                                                        value="{{ old('visa_expiry_date', $staff->visa_expiry_date ?? '') }}"
                                                        name="visa_expiry_date" placeholder="">
                                                    @error('visa_expiry_date')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="restriction">- Any restrictions?
                                                    </label>
                                                    <input class="form-control" type="text" id="restriction"
                                                        value="{{ old('restriction', $staff->restriction ?? '') }}"
                                                        name="restriction" placeholder="">
                                                    @error('restriction')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Next of Kin</label>
                                                <input class="form-control" type="text" name="next_of_kin"
                                                    value="{{ old('next_of_kin', $staff->next_of_kin ?? '') }}"
                                                    placeholder="">
                                                @error('next_of_kin')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship</label>
                                                <input class="form-control" type="text" name="relationship"
                                                    value="{{ old('relationship', $staff->relationship ?? '') }}"
                                                    placeholder="">
                                                @error('relationship')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input class="form-control" type="text" name="kin_address"
                                                    value="{{ old('kin_address', $staff->kin_address ?? '') }}"
                                                    placeholder="">
                                                @error('kin_address')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Suburb</label>
                                                <input class="form-control" type="text" name="kin_suburb"
                                                    value="{{ old('kin_suburb', $staff->kin_suburb ?? '') }}"
                                                    placeholder="">
                                                @error('kin_suburb')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input class="form-control" type="text" name="kin_state"
                                                    value="{{ old('kin_state', $staff->kin_state ?? '') }}"
                                                    placeholder="">
                                                @error('kin_state')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postcode</label>
                                                <input class="form-control" type="text" name="kin_postcode"
                                                    value="{{ old('kin_postcode', $staff->kin_postcode ?? '') }}"
                                                    placeholder="">
                                                @error('kin_postcode')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Home Phone</label>
                                                <input type="hidden" value="{{ old('kin_phone_country_dial_code') }}"
                                                    id="kin_phone_country_dial_code" name="kin_phone_country_dial_code">
                                                <input type="hidden" value="{{ old('kin_phone_iso2') }}"
                                                    id="kin_phone_iso2" name="kin_phone_iso2">
                                                <input type="tel" id="kin_phone" name="kin_phone"
                                                    value="{{ old('kin_phone', $staff->kin_phone ?? '') }}"
                                                    class="form-control" placeholder="">

                                                @error('kin_phone')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kin_mobile">Mobile Number</label>
                                                <input type="hidden" value="{{ old('kin_mobile_country_dialCode') }}"
                                                    id="kin_mobile_country_dialCode" name="kin_mobile_country_dialCode">
                                                <input type="hidden" value="{{ old('kin_mobile_iso2') }}"
                                                    id="kin_mobile_iso2" name="kin_mobile_iso2">
                                                <input type="tel" id="kin_mobile" name="kin_mobile"
                                                    value="{{ old('kin_mobile', $staff->kin_mobile ?? '') }}"
                                                    class="form-control" placeholder="">
                                                @error('kin_mobile')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="work">Work</label>

                                                <input type="text" id="work" name="kin_work"
                                                    value="{{ old('kin_work', $staff->kin_work ?? '') }}"
                                                    class="form-control" placeholder="">
                                                @error('work')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="work">Provided File:</label>
                                                <img src="{{ asset($staff->address_validate_file) }}"
                                                    alt="Thumbnail Image" id="thumbnail" class="thumbnail">
                                            </div>
                                        </div>




                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="address_validate_file">Upload a File to Validate
                                                    Address</label>
                                                <input type="file" id="address_validate_file"
                                                    name="address_validate_file"
                                                    value="{{ old('address_validate_file') }}" class="form-control"
                                                    placeholder="">
                                                @error('address_validate_file')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="about_validate_file">File Description</label>
                                                <input type="text" id="about_validate_file" name="about_validate_file"
                                                    value="{{ old('about_validate_file', $staff->about_validate_file) }}"
                                                    value="" class="form-control" placeholder="">
                                                @error('about_validate_file')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn prev-step">Back</button></li>
                                        <li><button type="submit" class="default-btn next-step"
                                                style="color: white;">Submit</button></li>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div id="abn_lookup" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ABN Informations</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <input class="form-control" type="hidden" size="10" id="TextBoxAddressPostcode"
                                value="" />
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label id="EntityNameLabel">Entity Name</label>
                                    <input class="form-control" type="text" size="100" id="TextBoxEntityName"
                                        disabled value="" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label id="AbnStatusLabel">ABN status:</label>
                                    <input class="form-control" type="text" size="50" id="TextBoxAbnStatus"
                                        disabled value="" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label id="AddressLabel">Address: </label>
                                    <input class="form-control" type="text" size="10" disabled
                                        id="TextBoxAddressState" value="" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label">Business names</label>
                                    <select id="businessNamesSelect" name="business_name" class="form-control">
                                        <option value="">Select</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="validate_file" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Provided File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group image-container">
                                    <img src="{{ asset($staff->address_validate_file) }}" alt="Large Image"
                                        class="full-width-image">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="modal" id="imageModal">
            <span class="close" onclick="closeModal()">&times;</span>
            <img src="{{ asset($staff->address_validate_file) }}" alt="Large Image" class="modal-content"
                id="modalImage">
        </div> --}}
    </section>
@endsection
@section('js')
    <script src="{{ asset('js/wizard.js') }}"></script>
    <script>
        $(document).ready(function() {
            //start same As  Physical address (this code will disable postal address if there is a validation error on form)
            //country code for phone
            var input = document.querySelector("#phone");
            var itiphone = window.intlTelInput(input, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('phone_iso2') }}"
            });

            // Retrieve selected country data
            function getSelectedCountryDataMobile() {
                var countryData = itiphone.getSelectedCountryData();
                var countryDialCode = countryData.dialCode;
                // Set the value of the hidden input field
                if (countryDialCode) {
                    document.getElementById('phone_country_dial_code').value = countryDialCode;
                    document.getElementById('phone_iso2').value = countryData.iso2;
                }
                // Check if there are old input values after validation

                var oldPhoneNumber = "{{ old('phone') }}";
                if (oldPhoneNumber !== '') {
                    $('#phone').val(oldPhoneNumber);
                }
            }

            // Event listener for when the country is changed
            input.addEventListener("countrychange", function() {
                getSelectedCountryDataMobile();
            });
            // Initial call to get selected country data
            getSelectedCountryDataMobile();



            //country code for mobile
            var inputMobile = document.querySelector("#mobile");
            var itimobile = window.intlTelInput(inputMobile, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('mobile_iso2') }}"
            });

            // Retrieve selected country data
            function getSelectedCountryDatamobile() {
                var countryData = itimobile.getSelectedCountryData();
                var countryDialCode = countryData.dialCode;
                // Set the value of the hidden inputMobile field
                if (countryDialCode) {
                    document.getElementById('mobile_country_dialCode').value = countryDialCode;
                    document.getElementById('mobile_iso2').value = countryData.iso2;
                }
                // Check if there are old inputMobile values after validation

                var oldmobile = "{{ old('mobile') }}";
                if (oldmobile !== '') {
                    // Set the value manually and then reinitialize the mobile inputMobile
                    $('#mobile').val(oldmobile);
                }
            }
            // Event listener for when the country is changed
            inputMobile.addEventListener("countrychange", function() {
                getSelectedCountryDatamobile();
            });
            // Initial call to get selected country data
            getSelectedCountryDatamobile();

            //country code for company_phone
            var inputcompany_phone = document.querySelector("#company_phone");
            var iticompany_phone = window.intlTelInput(inputcompany_phone, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('company_phone_iso2') }}"
            });

            // Retrieve selected country data
            function getSelectedCountryDatacompany_phone() {
                var countryData = iticompany_phone.getSelectedCountryData();
                var countryDialCode = countryData.dialCode;
                // Set the value of the hidden inputcompany_phone field
                if (countryDialCode) {
                    document.getElementById('company_phone_country_dialCode').value = countryDialCode;
                    document.getElementById('company_phone_iso2').value = countryData.iso2;
                }
                // Check if there are old inputcompany_phone values after validation

                var oldcompany_phone = "{{ old('company_phone') }}";
                if (oldcompany_phone !== '') {
                    // Set the value manually and then reinitialize the company_phone inputcompany_phone
                    $('#company_phone').val(oldcompany_phone);
                }
            }
            // Event listener for when the country is changed
            inputcompany_phone.addEventListener("countrychange", function() {
                getSelectedCountryDatacompany_phone();
            });
            // Initial call to get selected country data
            getSelectedCountryDatacompany_phone();



        });
        //country code for kin_phone
        var input = document.querySelector("#kin_phone");
        var itikin_phone = window.intlTelInput(input, {
            separateDialCode: true,
            preferredCountries: ["AU"],
            initialCountry: "{{ old('kin_phone_iso2') }}"
        });

        // Retrieve selected country data
        function getSelectedCountryDataMobile() {
            var countryData = itikin_phone.getSelectedCountryData();
            var countryDialCode = countryData.dialCode;
            // Set the value of the hidden input field
            if (countryDialCode) {
                document.getElementById('kin_phone_country_dial_code').value = countryDialCode;
                document.getElementById('kin_phone_iso2').value = countryData.iso2;
            }
            // Check if there are old input values after validation

            var oldPhoneNumber = "{{ old('kin_phone') }}";
            if (oldPhoneNumber !== '') {
                $('#kin_phone').val(oldPhoneNumber);
            }
        }

        // Event listener for when the country is changed
        input.addEventListener("countrychange", function() {
            getSelectedCountryDataMobile();
        });
        // Initial call to get selected country data
        getSelectedCountryDataMobile();



        //country code for kin_mobile
        var inputMobile = document.querySelector("#kin_mobile");
        var itikin_mobile = window.intlTelInput(inputMobile, {
            separateDialCode: true,
            preferredCountries: ["AU"],
            initialCountry: "{{ old('kin_mobile_iso2') }}"
        });

        // Retrieve selected country data
        function getSelectedCountryDatakin_mobile() {
            var countryData = itikin_mobile.getSelectedCountryData();
            var countryDialCode = countryData.dialCode;
            // Set the value of the hidden inputMobile field
            if (countryDialCode) {
                document.getElementById('kin_mobile_country_dialCode').value = countryDialCode;
                document.getElementById('kin_mobile_iso2').value = countryData.iso2;
            }
            // Check if there are old inputMobile values after validation

            var oldkin_mobile = "{{ old('kin_mobile') }}";
            if (oldkin_mobile !== '') {
                // Set the value manually and then reinitialize the kin_mobile inputMobile
                $('#kin_mobile').val(oldkin_mobile);
            }
        }
        // Event listener for when the country is changed
        inputMobile.addEventListener("countrychange", function() {
            getSelectedCountryDatakin_mobile();
        });
        // Initial call to get selected country data
        getSelectedCountryDatakin_mobile();
    </script>
    <script>
        $(document).ready(function() {
            // Add a click event listener to the submit button in the modal
            $('.submit-btn').on('click', function() {

                // Get values from modal fields
                const entityName = $('#TextBoxEntityName').val();
                const abnStatus = $('#TextBoxAbnStatus').val();
                const addressState = $('#TextBoxAddressState').val();
                const businessName = $('#businessNamesSelect').val();
                // console.log(entityName, businessName);
                // Set values to hidden input fields
                // $('input[name="abn_entity_name"]').val(entityName);
                // $('input[name="abn_status"]').val(abnStatus);
                // $('input[name="abn_address"]').val(addressState);
                $('input[name="abn_business_name"]').val(businessName);

                // Close the modal or submit the form
                $('#abn_lookup').modal('hide'); // To close the modal
                // Example: $('#yourFormId').submit(); // To submit the form
            });
        });
    </script>

    <script>
        // Open modal function
        function openModal() {
            // document.getElementById('imageModal').style.display = 'block';
            $("#validate_file").modal("show");
        }
        // Close modal function
        function closeModal() {
            document.getElementById('imageModal').style.display = 'none';
        }
        // Triggering the modal on thumbnail click
        document.getElementById('thumbnail').addEventListener('click', function() {
            openModal();
        });
    </script>
@endsection

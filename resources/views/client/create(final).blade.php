<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Client Information</title>
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/opensans-font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/roboto-font.css') }}">
    <link rel="stylesheet" type="text/css "
        href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css"> --}}
    <!-- Add these lines in the <head> section of your HTML -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <style>
        .underline-text {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="page-content">
        <div class="wizard-v4-content">
            <div class="wizard-form">
                <div class="wizard-header">

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
                    <h3 class="heading">Add New Client</h3>
                    <p>Client Informations </p>
                </div>
                <form class="form-register" id="myForm" action="{{ route('client.store') }}" method="post">
                    @csrf
                    <div id="form-total">
                        <!-- SECTION 1 -->
                        <h2>
                            <span class="step-icon"><i class="zmdi zmdi-account"></i></span>
                            <span class="step-text"> General Details </span>
                        </h2>
                        <section>
                            <div class="inner">
                                <div class="form-group">
                                    <label for="exampleSelect">Business Structure</label>
                                    <select class="form-control" name="business_structure" id="exampleSelect">
                                        <option value="Other"
                                            {{ old('business_structure') == 'Other' ? 'selected' : '' }}>
                                            Other </option>
                                        <option value="Partnership"
                                            {{ old('business_structure') == 'Partnership' ? 'selected' : '' }}>
                                            Partnership </option>
                                        <option value="Self Managed Superannuation Form"
                                            {{ old('business_structure') == 'Self Managed Superannuation Form' ? 'selected' : '' }}>
                                            Self Managed Superannuation Form
                                        </option>
                                        <option value="Sole Trader"
                                            {{ old('business_structure') == 'Sole Trader' ? 'selected' : '' }}>Sole
                                            Trader
                                        </option>
                                        <option value="Superannuation Fund"
                                            {{ old('business_structure') == 'Superannuation Fund' ? 'selected' : '' }}>
                                            Superannuation Fund </option>
                                        <option value="Trust"
                                            {{ old('business_structure') == 'Trust' ? 'selected' : '' }}>
                                            Trust </option>
                                        <option value="Trust-state"
                                            {{ old('business_structure') == 'Trust-state' ? 'selected' : '' }}>
                                            Trust-state
                                        </option>
                                        <option value="Unit-Trust"
                                            {{ old('business_structure') == 'Unit-Trust' ? 'selected' : '' }}>
                                            Unit-Trust
                                        </option>
                                    </select>
                                    {{-- <label for="business_structure">Business Structure</label>
                                    <input required type="text" id="business_structure" name="business_structure"
                                        class="form-control" placeholder="Enter Business Structure" required> --}}
                                </div>
                                <div class="form-group">
                                    <label for="exampleSelect">Client Type</label>
                                    <select class="form-control" name="client_type" id="exampleSelect">
                                        <option value="Company">Company </option>
                                        <option value="Partnership"
                                            {{ old('business_structure') == 'Partnership' ? 'selected' : '' }}>
                                            Partnership </option>
                                        <option value="Self Managed Superannuation Form"
                                            {{ old('business_structure') == 'Self Managed Superannuation Form' ? 'selected' : '' }}>
                                            Self Managed Superannuation Form
                                        </option>
                                        {{-- <option value="Sole Trader">Sole Trader </option> --}}
                                        {{-- <option value="Superannuation Fund">Superannuation Fund </option> --}}
                                        <option value="Trust"
                                            {{ old('business_structure') == 'Trust' ? 'selected' : '' }}>
                                            Trust </option> {{-- <option value="Trust-state">Trust-state </option> --}}
                                        {{-- <option value="Unit-Trust">Unit-Trust </option> --}}
                                    </select>
                                    {{-- <label for="business_structure">Business Structure</label>
                                    <input required type="text" id="business_structure" name="business_structure"
                                        class="form-control" placeholder="Enter Business Structure" required> --}}
                                </div>
                                {{-- <fieldset class="form-group">
                                    <div class="row">
                                        <legend class="col-form-label col-sm-4 pt-0">Client Type</legend>
                                        <div class="col-sm-8">
                                            <div class="form-check">
                                                <input required class="form-check-input" type="radio" name="client_type"
                                                    id="client_type" value="Individual" checked>
                                                <label class="form-check-label" for="client_type">
                                                    Individual
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input required class="form-check-input" type="radio" name="client_type"
                                                    id="client_type" value="Company">
                                                <label class="form-check-label" for="client_type">
                                                    Company
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset> --}}

                                <div class="form-group">
                                    <label for="full_legal_name">Full Legal Name</label>
                                    <input required type="text" id="full_legal_name" name="full_legal_name"
                                        value="{{ old('full_legal_name') }}" class="form-control"
                                        placeholder="Enter Full Legal Name">
                                    @error('full_legal_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- <h3>Personal Information:</h3> --}}
                                {{-- <div class="form-row">

                                    <div class="form-holder">
                                        <label class="form-row-inner">
                                            <input required type="text" id="phone" name="phone"
                                                value="{{ old('phone') }}" class="form-control">
                                            <span class="label">Phone Number</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                    <div class="form-holder">
                                        <label class="form-row-inner">
                                            <input type="text" class="form-control" id="last-name" name="last-name"
                                                required>
                                            <span class="label">Last Name</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-holder form-holder-1">
                                        <label class="form-row-inner">
                                            <input type="text" class="form-control" id="address" name="address"
                                                required>
                                            <span class="label">Address Location</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                    <div class="form-holder">
                                        <label class="form-row-inner">
                                            <input type="text" class="form-control" id="code" name="code"
                                                required>
                                            <span class="label">Zip Code</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <label class="form-row-inner">
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                required>
                                            <span class="label">Phone Number</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                </div> --}}
                            </div>
                        </section>
                        <!-- SECTION 2 -->
                        <h2>
                            <span class="step-icon"><i class="zmdi zmdi-lock"></i></span>
                            <span class="step-text">Contact Details</span>
                        </h2>

                        <section>
                            <div class="inner">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="phone">Phone Number</label>
                                        <input type="hidden" value="{{ old('phone_country_dial_code') }}"
                                            id="phone_country_dial_code" name="phone_country_dial_code">
                                        <input type="hidden" value="{{ old('phone_iso2') }}" id="phone_iso2"
                                            name="phone_iso2">
                                        <input required type="tel" id="phone" name="phone" value=""
                                            class="form-control" placeholder="Enter Phone Number">
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- <div class="form-group col-md-6">
                                        <label for="phone">Phone</label>
                                        <input type="tel" id="phone" name="phone" class="form-control"
                                            placeholder="Enter Phone Number">
                                        <input required type="text" id="phone" name="phone"
                                            value="{{ old('phone') }}" class="form-control"
                                            placeholder="Enter Phone Number">
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group col-md-6">
                                        <label for="fax">Fax Number</label>
                                        <input type="hidden" value="{{ old('fax_country_dialCode') }}"
                                            id="fax_country_dialCode" name="fax_country_dialCode">
                                        <input type="hidden" value="{{ old('fax_iso2') }}" id="fax_iso2"
                                            name="fax_iso2">

                                        <input required type="tel" id="fax" name="fax" value=""
                                            class="form-control" placeholder="Enter Fax Number">
                                        @error('fax')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- <div class="form-group">
                                    <label for="contactName">Name:</label>
                                    <input  required type="text" id="contactName" name="contactName" class="form-control"
                                        placeholder="Enter contact name">
                                </div> --}}
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input required type="email" id="email" name="email"
                                        value="{{ old('email') }}" class="form-control"
                                        placeholder="Enter Contact Email" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror

                                </div>
                                {{-- <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <label for="email">Email Address*</label>
                                        <input type="email" placeholder="Your Email" class="form-control"
                                            id="email" name="email" required
                                            pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
                                    </div>
                                </div> --}}
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input required type="text" id="website" name="website"
                                        value="{{ old('website') }}" class="form-control" placeholder="Website">
                                    @error('website')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="website" class="underline-text font-weight-bold">Physical
                                        Address</label>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="physical_street">Street</label>
                                            <input required type="text" id="physical_street"
                                                value="{{ old('physical_street') }}" name="physical_street"
                                                class="form-control" placeholder="Enter Street ">
                                            @error('physical_street')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="physical_city">Town/City</label>
                                            <input required type="text" id="physical_city"
                                                value="{{ old('physical_city') }}" name="physical_city"
                                                class="form-control" placeholder="Enter Town/City">
                                            @error('physical_city')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="physical_state">State/Region</label>
                                            <input required type="text" id="physical_state"
                                                value="{{ old('physical_state') }}" name="physical_state"
                                                class="form-control" placeholder="Enter State/Region ">
                                            @error('physical_state')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="physical_postal_code">Postal/Zip Code</label>
                                            <input required type="text" id="physical_postal_code"
                                                value="{{ old('physical_postal_code') }}" name="physical_postal_code"
                                                class="form-control" placeholder="Enter Postal/Zip Code">
                                            @error('physical_postal_code')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="physical_country">Country</label>
                                            <input required type="text" id="physical_country"
                                                name="physical_country" value="{{ old('physical_country') }}"
                                                class="form-control" placeholder="Enter Country ">
                                            @error('physical_country')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check m-2 p-2">
                                    <input class="form-check-input" type="checkbox" value="1"
                                        {{ old('sameAsPhysical') ? 'checked' : '' }} id="sameAsPhysical"
                                        name="sameAsPhysical" onclick="disablePostal()">
                                    <label class="form-check-label " for="sameAsPhysical">
                                        Same as Physical Address
                                    </label>
                                </div>

                                <div class="form-group" id="postal_address">
                                    <label for="website" class="underline-text font-weight-bold">Postal
                                        Address</label>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="postal_street">Street</label>
                                            <input type="text" id="postal_street"
                                                value="{{ old('postal_street') }}" name="postal_street"
                                                class="form-control" placeholder="Enter Street ">
                                            @error('postal_street')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="postal_city">Town/City</label>
                                            <input type="text" id="postal_city" value="{{ old('postal_city') }}"
                                                name="postal_city" class="form-control"
                                                placeholder="Enter Town/City">
                                            @error('postal_city')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="postal_state">State/Region</label>
                                            <input type="text" id="postal_state"
                                                value="{{ old('postal_state') }}" name="postal_state"
                                                class="form-control" placeholder="Enter State/Region ">
                                            @error('postal_state')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="postal_postal_code">Postal/Zip Code</label>
                                            <input type="text" id="postal_postal_code"
                                                value="{{ old('postal_postal_code') }}" name="postal_postal_code"
                                                class="form-control" placeholder="Enter Postal/Zip Code">
                                            @error('postal_postal_code')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="postal_country">Country</label>
                                            <input type="text" id="postal_country" name="postal_country"
                                                value="{{ old('postal_country') }}" class="form-control"
                                                placeholder="Enter Country ">
                                            @error('postal_country')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- <h3>Do you have an account?</h3> --}}
                                {{-- <div class="form-row">
                                    <div id="radio">
                                        <input type="radio" name="gender" value="male" checked class="radio-1"> I
                                        already have an account.
                                        <input type="radio" name="gender" value="female"> I'm newbie
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <label class="form-row-inner">
                                            <input type="text" name="your_email_1" id="your_email_1"
                                                class="form-control" required>
                                            <span class="label">E-Mail</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder">
                                        <label class="form-row-inner">
                                            <input type="password" name="password_1" id="password_1"
                                                class="form-control" required>
                                            <span class="label">Password</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                    <div class="form-holder">
                                        <label class="form-row-inner">
                                            <input type="password" name="comfirm_password_1" id="comfirm_password_1"
                                                class="form-control" required>
                                            <span class="label">Comfirm Password</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                </div> --}}
                            </div>
                        </section>
                        <!-- SECTION 3 -->
                        <h2>
                            <span class="step-icon"><i class="zmdi zmdi-receipt"></i></span>
                            <span class="step-text">Tax & Company</span>
                        </h2>
                        <section>
                            <div class="inner">
                                <h3>Tax & Company Details</h3>
                                <div class="form-group">
                                    <label for="tax_file_number">Tax File Number(TFN)</label>
                                    <input required type="text" id="tax_file_number" name="tax_file_number"
                                        value="{{ old('tax_file_number') }}" class="form-control"
                                        placeholder="Enter Tax File Number">
                                    @error('tax_file_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="business_number">Australian Business Number(ABN)</label>
                                    <input required type="text" id="business_number" name="business_number"
                                        value="{{ old('business_number') }}" class="form-control"
                                        placeholder="Enter Australian Business Number">
                                    @error('business_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="company_number">Australian Company Number(ACN)</label>
                                    <input required type="text" id="company_number" name="company_number"
                                        value="{{ old('company_number') }}" class="form-control"
                                        placeholder="Enter Australian Company Number">
                                    @error('company_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                {{-- <div class="form-row">
                                    <div class="form-holder">
                                        <label class="form-row-inner">
                                            <input type="text" class="form-control" id="first-name-1"
                                                name="first-name-1" required>
                                            <span class="label">First Name</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                    <div class="form-holder">
                                        <label class="form-row-inner">
                                            <input type="text" class="form-control" id="last-name-1"
                                                name="last-name-1" required>
                                            <span class="label">Last Name</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <select name="position" id="position">
                                            <option value="Position" disabled selected>Position</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Employee">Employee</option>
                                            <option value="Director">Director</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <select name="area" id="area">
                                            <option value="Business Area" disabled selected>Business Area</option>
                                            <option value="Marketing">Marketing</option>
                                            <option value="Finance">Finance</option>
                                            <option value="IT Support">IT Support</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row form-row-date">
                                    <div class="form-holder form-holder-2">
                                        <label for="date" class="special-label">Date of Birth:</label>
                                        <select name="date" id="date">
                                            <option value="Day" disabled selected>Day</option>
                                            <option value="16">16</option>
                                            <option value="17">17</option>
                                            <option value="18">18</option>
                                            <option value="19">19</option>
                                        </select>
                                        <select name="month" id="month">
                                            <option value="Month" disabled selected>Month</option>
                                            <option value="Feb">Feb</option>
                                            <option value="Mar">Mar</option>
                                            <option value="Apr">Apr</option>
                                            <option value="May">May</option>
                                        </select>
                                        <select name="year" id="year">
                                            <option value="Year" disabled selected>Year</option>
                                            <option value="2017">2017</option>
                                            <option value="2016">2016</option>
                                            <option value="2015">2015</option>
                                            <option value="2014">2014</option>
                                            <option value="2013">2013</option>
                                        </select>
                                    </div>
                                </div> --}}
                            </div>
                        </section>
                        <!-- SECTION 4 -->
                        <h2>
                            <span class="step-icon"><i class="zmdi zmdi-money"></i></span>
                            <span class="step-text">Bank Details</span>
                        </h2>
                        <section>
                            <div class="inner">
                                <h3>Bank Details & Aditional Information</h3>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="account_name">Account Name</label>
                                        <input required type="text" id="account_name" name="account_name"
                                            value="{{ old('account_name') }}" class="form-control"
                                            placeholder="Enter Account Name ">
                                        @error('account_name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="account_number">Account Number</label>
                                        <input required type="text" id="account_number" name="account_number"
                                            value="{{ old('account_number') }}" class="form-control"
                                            placeholder="Enter Account Number">
                                        @error('account_number')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="financial_institution_name">Financial Instituion Name</label>
                                    <input required type="text" id="financial_institution_name"
                                        value="{{ old('financial_institution_name') }}"
                                        name="financial_institution_name" class="form-control"
                                        placeholder="Enter Financial Instituion Name">
                                    @error('financial_institution_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="bsb_number">BSB Number</label>
                                    <input required type="text" id="bsb_number" name="bsb_number"
                                        class="form-control" value="{{ old('bsb_number') }}"
                                        placeholder="Enter BSB Number">
                                    @error('bsb_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    {{-- <div class="col-sm-8">Prepare Activity Statement</div> --}}
                                    <div class="col-sm-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="activity_statement"
                                                value="1" id="activity_statement"
                                                {{ old('activity_statement') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gridCheck1">
                                                Prepare Activity Statement </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{-- <div class="col-sm-8">Prepare Tax Form</div> --}}
                                    <div class="col-sm-12">
                                        <div class="form-check">

                                            <input class="form-check-input" type="checkbox" name="tax_form"
                                                value="1" id="tax_form" {{ old('tax_form') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gridCheck1">
                                                Prepare Tax Form
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{-- <div class="col-sm-8">Active ATO Client</div> --}}
                                    <div class="col-sm-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="ato_client"
                                                value="1" id="ato_client"
                                                {{ old('ato_client') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gridCheck1">
                                                Active ATO Client </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{-- <div class="col-sm-4">Verification Document Provided</div> --}}
                                    <div class="col-sm-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="verification_document" value="1"
                                                id="verification_document"
                                                {{ old('verification_document') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="gridCheck1">
                                                Verification Document Provided
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleSelect">Document Type</label>
                                    <select class="form-control" name="document_type" id="exampleSelect">
                                        <option value="Financial Documents"
                                            {{ old('document_type') == 'Financial Documents' ? 'selected' : '' }}>
                                            Financial
                                            Documents </option>
                                    </select>

                                </div>
                                {{-- <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <select name="inventory" id="inventory">
                                            <option value="Buy Inventory" disabled selected>Buy Inventory</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div id="checkbox">
                                        <span>Do you have existing business financing?: </span>
                                        <input type="checkbox" name="vehicle1" value="Yes"> Yes
                                        <input type="checkbox" name="vehicle2" value="No"> No
                                    </div>
                                </div>
                                <h4>Existing Balance </h4>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <label class="form-row-inner">
                                            <input type="text" name="business" id="business"
                                                class="form-control" required>
                                            <span class="label">Business</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-holder form-holder-2">
                                        <label class="form-row-inner">
                                            <input type="text" name="balance" id="balance" class="form-control"
                                                required>
                                            <span class="label">Current Balance</span>
                                            <span class="border"></span>
                                        </label>
                                    </div>
                                </div> --}}
                            </div>
                        </section>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add this script at the end of your HTML body -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.steps.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(document).ready(function() {

            //start same As  Physical address (this code will disable postal address if there is a validation error on form)
            const sameAsPhysicalCheckbox = document.querySelector('#sameAsPhysical');
            const postalAddressFields = document.querySelectorAll('#postal_address input');
            // console.log(postalAddressFields);
            if ("{{ old('sameAsPhysical') }}") {
                // console.log('hello');
                postalAddressFields.forEach(field => {
                    field.disabled = true;
                });
            } else {
                postalAddressFields.forEach(field => {
                    field.disabled = false;
                });
            }
            //end sameAsPhysicalCheckbox

            //country code for phone

            var input = document.querySelector("#phone");

            var itiphone = window.intlTelInput(input, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('phone_iso2') }}"
            });

            // Retrieve selected country data
            function getSelectedCountryData() {
                var countryData = itiphone.getSelectedCountryData();
                // console.log(countryData);
                // console.log(countryData.iso2);
                // console.log(countryData.dialCode);
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
                getSelectedCountryData();
            });
            // Initial call to get selected country data
            getSelectedCountryData();
            //country code for fax

            var inputFax = document.querySelector("#fax");
            var iti = window.intlTelInput(inputFax, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('fax_iso2') }}"
            });

            // Retrieve selected country data
            function getSelectedCountryDatafax() {
                var countryData = iti.getSelectedCountryData();
                // console.log(countryData);
                // console.log(countryData.iso2);
                // console.log(countryData.dialCode);
                var countryDialCode = countryData.dialCode;
                // Set the value of the hidden inputFax field
                if (countryDialCode) {
                    document.getElementById('fax_country_dialCode').value = countryDialCode;
                    document.getElementById('fax_iso2').value = countryData.iso2;
                }
                // Check if there are old inputFax values after validation

                var oldfax = "{{ old('fax') }}";
                if (oldfax !== '') {
                    // Set the value manually and then reinitialize the fax inputFax
                    $('#fax').val(oldfax);
                }
            }
            // Event listener for when the country is changed
            inputFax.addEventListener("countrychange", function() {
                getSelectedCountryDatafax();
            });
            // Initial call to get selected country data
            getSelectedCountryDatafax();
        });
    </script>

    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}


    {{-- <script>
        $(document).ready(function() {
            $('#emailInput').on('input', function() {
                var email = $(this).val();
                $('#email-val').text(email);
            });
        });
    </script> --}}

    {{-- this code will disable all the input fields of postal_address if (same as ) checked  --}}
    <script>
        function disablePostal() {
            const sameAsPhysicalCheckbox = document.querySelector('#sameAsPhysical');
            const postalAddressFields = document.querySelectorAll('#postal_address input');
            // console.log(postalAddressFields);
            // const isSameAsPhysicalFromServer = {{ old('sameAsPhysical') }};
            if (sameAsPhysicalCheckbox.checked == true) {
                // console.log('hello');
                postalAddressFields.forEach(field => {
                    field.disabled = true;
                });
            } else {
                postalAddressFields.forEach(field => {
                    field.disabled = false;
                });
                // text.style.display = "none";
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.wizard-v4-content').on('click', 'a[href="#finish"]', function(event) {
                event.preventDefault(); // Prevent default link behavior
                $('#myForm').submit(); // Submit the form with ID 'myForm'
            });
        });
    </script>
    {{-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> --}}
</body>

</html>

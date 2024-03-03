@extends('layouts.admin.master')
@section('title')
    Business Profile Information
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/opensans-font.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/roboto-font.css') }}">
    <link rel="stylesheet" type="text/css "
        href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery-ui.min.css') }}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://jqueryvalidation.org/files/demo/site-demos.css"> --}}
    {{-- for number --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <style>
        .underline-text {
            text-decoration: underline;
        }
    </style>
@endsection
@section('content')
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
                    <h3 class="heading">Add Business Profile </h3>
                    <p>Business Profile Informations </p>
                </div>
                <form class="form-register" id="myForm" action="{{ route('business.store') }}" method="post">
                    @csrf
                    <div id="form-total">

                        <h2>
                            {{-- <span class="step-icon"><i class="zmdi zmdi-lock"></i></span> --}}
                            {{-- <span class="step-text">Contact Details</span> --}}
                        </h2>

                        <section>
                            <div class="inner">
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <input required type="text" id="company_name" name="company_name"
                                        value="{{ old('company_name') }}" class="form-control" placeholder="Company Name">
                                    @error('company_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="company_type">Company Type</label>
                                    <input required type="text" id="company_type" name="company_type"
                                        value="{{ old('company_type') }}" class="form-control" placeholder="Company Type">
                                    @error('company_type')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="business_number">Australian Business Number(ABN)</label>
                                        <input required type="text" id="business_number" name="business_number"
                                            value="{{ old('business_number') }}" class="form-control"
                                            placeholder="Enter ANB">
                                        @error('business_number')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="company_number">Australian Company Number(ACN)</label>
                                        <input required type="text" id="company_number" name="company_number"
                                            value="{{ old('company_number') }}" class="form-control"
                                            placeholder="Enter ACN">
                                        @error('company_number')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>


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
                                    <div class="form-group col-md-6">
                                        <label for="fax">Fax Number</label>
                                        <input type="hidden" value="{{ old('fax_country_dialCode') }}"
                                            id="fax_country_dialCode" name="fax_country_dialCode">
                                        <input type="hidden" value="{{ old('fax_iso2') }}" id="fax_iso2" name="fax_iso2">

                                        <input required type="tel" id="fax" name="fax" value=""
                                            class="form-control" placeholder="Enter Fax Number">
                                        @error('fax')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="hidden" value="{{ old('mobile_country_dialCode') }}"
                                            id="mobile_country_dialCode" name="mobile_country_dialCode">
                                        <input type="hidden" value="{{ old('mobile_iso2') }}" id="mobile_iso2"
                                            name="mobile_iso2">
                                        <input required type="tel" id="mobile" name="mobile" value=""
                                            class="form-control" placeholder="Enter Mobile Number">
                                        @error('mobile')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <input required type="email" id="email" name="email"
                                            value="{{ old('email') }}" class="form-control"
                                            placeholder="Enter Contact Email" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="" class="underline-text font-weight-bold">Physical
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
                                            <input required type="text" id="physical_country" name="physical_country"
                                                value="{{ old('physical_country') }}" class="form-control"
                                                placeholder="Enter Country ">
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
                                    <label for="" class="underline-text font-weight-bold">Postal
                                        Address</label>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="postal_street">Street</label>
                                            <input type="text" id="postal_street" value="{{ old('postal_street') }}"
                                                name="postal_street" class="form-control" placeholder="Enter Street ">
                                            @error('postal_street')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="postal_city">Town/City</label>
                                            <input type="text" id="postal_city" value="{{ old('postal_city') }}"
                                                name="postal_city" class="form-control" placeholder="Enter Town/City">
                                            @error('postal_city')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="postal_state">State/Region</label>
                                            <input type="text" id="postal_state" value="{{ old('postal_state') }}"
                                                name="postal_state" class="form-control"
                                                placeholder="Enter State/Region ">
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

                                <div class="form-group">
                                    <label for="accountants_number">How many accountants in your
                                        company?</label>
                                    <input required type="number" id="accountants_number" name="accountants_number"
                                        value="{{ old('accountants_number') }}" class="form-control"
                                        placeholder="Enter number of accountants.">
                                    @error('accountants_number')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="software_name">Which accounting Software do you
                                        use?</label>
                                    <input required type="text" id="software_name" name="software_name"
                                        value="{{ old('software_name') }}" class="form-control"
                                        placeholder="Enter software name.">
                                    @error('software_name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="api_key">APi Key</label>
                                    <input required type="text" id="api_key" name="api_key"
                                        value="{{ old('api_key') }}" class="form-control"
                                        placeholder="Enter your APi Key.">
                                    @error('api_key')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
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

            //country code for fax
            var inputFax = document.querySelector("#fax");
            var itifax = window.intlTelInput(inputFax, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('fax_iso2') }}"
            });

            // Retrieve selected country data
            function getSelectedCountryDatafax() {
                var countryData = itifax.getSelectedCountryData();
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
        });
    </script>

    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}

    {{-- this code will disable all the input fields of postal_address if (same as ) checked  --}}
    <script>
        function disablePostal() {
            const sameAsPhysicalCheckbox = document.querySelector('#sameAsPhysical');
            const postalAddressFields = document.querySelectorAll('#postal_address input');
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
@endsection

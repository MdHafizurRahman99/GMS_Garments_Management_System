@extends('layouts.admin.master')

@section('title')
    Staff Details
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/wizard.css') }}">
    {{-- for abn start --}}
    <script src="{{ asset('js/abn/json.js') }}"></script>
    <script src="{{ asset('js/abnlookup-sample.js') }}"></script>
    {{-- for abn end --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
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
                                <li role="presentation" class="disabled">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab"
                                        aria-expanded="false"><span class="round-tab">2</span> <i>Step 2</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span
                                            class="round-tab">3</span> <i>Step 3</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span
                                            class="round-tab">4</span> <i>Step 4</i></a>
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

                        <form role="form" action="{{ route('staff.store') }}" class="login-box" method="POST">
                            @csrf
                            <div class="tab-content" id="main_form">
                                <div class="tab-pane active" role="tabpanel" id="step1">
                                    <h4 class="text-center">Employee or Contractor Details </h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name">First Name *</label>
                                                <input type="text" id="first_name" name="first_name"
                                                    value="{{ old('first_name') }}" class="form-control"
                                                    placeholder="First Name">
                                                @error('first_name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name*</label>
                                                <input type="text" id="last_name" name="last_name"
                                                    value="{{ old('last_name') }}" class="form-control"
                                                    placeholder="Last Name">
                                                @error('last_name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input class="form-control" type="date" name="start_date"
                                                    value="{{ old('start_date') }}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Possion Title</label>
                                                <input class="form-control" type="text"
                                                    value="{{ old('possion_title') }}" name="possion_title" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gender</label>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                            value="Male"
                                                            {{ old('gender') == 'Male' ? 'checked' : '' }}>Male
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender"
                                                            value="Female"
                                                            {{ old('gender') == 'Female' ? 'checked' : '' }}>Female
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Date of Birth</label>
                                                <input class="form-control" type="date" name="date_of_birth"
                                                    value="{{ old('date_of_birth') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input class="form-control" type="text" name="address"
                                                    value="{{ old('address') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Suburb</label>
                                                <input class="form-control" type="text" name="suburb"
                                                    value="{{ old('suburb') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input class="form-control" type="text" name="state"
                                                    value="{{ old('state') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postcode</label>
                                                <input class="form-control" type="text" name="postcode"
                                                    value="{{ old('postcode') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Home Phone</label>
                                                <input type="hidden" value="{{ old('phone_country_dialCode') }}"
                                                    id="phone_country_dialCode" name="phone_country_dialCode">
                                                <input type="hidden" value="{{ old('phone_iso2') }}" id="phone_iso2"
                                                    name="phone_iso2">
                                                <input type="tel" id="phone" name="phone" value=""
                                                    class="form-control" placeholder="">
                                                @error('phone')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="work">Mobile Number</label>
                                                <input type="hidden" value="{{ old('mobile_country_dialCode') }}"
                                                    id="mobile_country_dialCode" name="mobile_country_dialCode">
                                                <input type="hidden" value="{{ old('mobile_iso2') }}" id="mobile_iso2"
                                                    name="mobile_iso2">
                                                <input type="tel" id="mobile" name="mobile"
                                                    value="{{ old('mobile') }}" class="form-control" placeholder="">
                                                @error('mobile')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Email</label>
                                                {{ Auth::check() ? Auth::user()->email : 'Not logged in' }}
                                                <input class="form-control" type="email" name="email"
                                                    value="{{ old('email', Auth::user()->email ?? '') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="employee_tax_file">Employee Tax File</label>
                                                <input type="text" id="employee_tax_file" name="employee_tax_file"
                                                    value="{{ old('employee_tax_file') }}" class="form-control"
                                                    placeholder="">
                                                @error('employee_tax_file')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="super_fund">Existing super fund (if any)</label>
                                                <input type="text" id="super_fund" name="super_fund"
                                                    value="{{ old('super_fund') }}" class="form-control" placeholder="">
                                                @error('super_fund')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="member_no">Member No </label>
                                                <input type="text" id="member_no" name="member_no"
                                                    value="{{ old('member_no') }}" class="form-control" placeholder="">
                                                @error('member_no')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="default-btn next-step"
                                                style="color: white;">Continue to next
                                                step</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step2">
                                    <h4 class="text-center">Details for contractors</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Company Name</label>
                                                <input class="form-control" type="text" name="company_name"
                                                    value="{{ old('company_name') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Company Address</label>
                                                <input class="form-control" type="text" name="company_address"
                                                    value="{{ old('company_address') }}" placeholder="">
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
                                                    value="{{ old('company_phone') }}" name="company_phone"
                                                    placeholder="">
                                                @error('company_phone')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Company Email</label>
                                                <input class="form-control" type="email" name="company_email"
                                                    value="{{ old('company_email') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="business_number">Australian Business Number(ABN)</label>


                                                <input type="text" id="TextBoxAbn" name="business_number"
                                                    value="{{ old('business_number') }}" class="form-control"
                                                    placeholder="">

                                                <input name="TextBoxGuid" type="hidden"
                                                    value="1d25add7-1327-4ed6-bd85-d8318553340e" id="TextBoxGuid" />
                                                <input type="button" name="ButtonAbnLookup" value="ABN Lookup"
                                                    id="ButtonAbnLookup" onclick="abnLookup('TextBoxAbn','TextBoxGuid');"
                                                    class="form-control btn-primary mt-2  " />
                                                <label style="display: none;" id="EntityNameLabel">Entity Name</label>
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
                                                    class="form-control btn-secondary mt-2" />
                                                @error('business_number')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="company_number">Australian Company Number(ACN)</label>
                                                <input type="text" id="company_number" name="company_number"
                                                    value="{{ old('company_number') }}" class="form-control"
                                                    placeholder="">
                                                @error('company_number')
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
                                <div class="tab-pane" role="tabpanel" id="step3">
                                    <h4 class="text-center">Bank Details </h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Bank Name</label>
                                                <input class="form-control" type="text" name="bank_name"
                                                    value="{{ old('bank_name') }}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Branch</label>
                                                <input class="form-control" type="text" name="branch"
                                                    value="{{ old('branch') }}" placeholder="">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Account Name</label>
                                                <input class="form-control" type="text" name="account_name"
                                                    value="{{ old('account_name') }}" placeholder="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="bsb_number">BSB Number</label>
                                                <input type="text" id="bsb_number" name="bsb_number"
                                                    class="form-control" value="{{ old('bsb_number') }}"
                                                    placeholder="Enter BSB Number">
                                                @error('bsb_number')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="account_number">Account Number</label>
                                                <input type="text" id="account_number" name="account_number"
                                                    value="{{ old('account_number') }}" class="form-control"
                                                    placeholder="Enter Account Number">
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
                                                            {{ old('aus_citizen') == 'Yes' ? 'checked' : '' }}>Yes
                                                        &emsp;
                                                        <input type="radio" class="form-check-input" name="aus_citizen"
                                                            value="No"
                                                            {{ old('aus_citizen') == 'No' ? 'checked' : '' }}>No
                                                    </label>
                                                </div>
                                                {{-- <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="aus_citizen"
                                                            value="No">No
                                                    </label>
                                                </div> --}}
                                                <label>If no, </label>
                                                <br>
                                                <div class="col-md-6">

                                                    <label>- Are you a permanent resident? </label>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="radio" class="form-check-input"
                                                                name="permanent_resident" value="Yes"
                                                                {{ old('permanent_resident') == 'Yes' ? 'checked' : '' }}>Yes
                                                            &emsp;
                                                            <input type="radio" class="form-check-input"
                                                                name="permanent_resident" value="No"
                                                                {{ old('permanent_resident') == 'No' ? 'checked' : '' }}>No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="visa_expiry_date">- Do you have a Working Visa? Expiry
                                                        date:
                                                    </label>
                                                    {{-- <label for="visa_expiry_date">- Do you have a Working Visa? Expiry
                                                        date:
                                                    </label> --}}
                                                    <input class="form-control" type="date" id="visa_expiry_date"
                                                        value="{{ old('visa_expiry_date') }}" name="visa_expiry_date"
                                                        placeholder="">
                                                    @error('visa_expiry_date')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror

                                                </div>
                                                <div class="col-md-6">
                                                    <label for="restriction">- Any restrictions?
                                                    </label>
                                                    <input class="form-control" type="text" id="restriction"
                                                        value="{{ old('restriction') }}" name="restriction"
                                                        placeholder="">
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
                                                    value="{{ old('next_of_kin') }}" placeholder="">
                                                @error('next_of_kin')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Relationship</label>
                                                <input class="form-control" type="text" name="relationship"
                                                    value="{{ old('relationship') }}" placeholder="">
                                                @error('relationship')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input class="form-control" type="text" name="kin_address"
                                                    value="{{ old('kin_address') }}" placeholder="">
                                                @error('kin_address')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Suburb</label>
                                                <input class="form-control" type="text" name="kin_suburb"
                                                    value="{{ old('kin_suburb') }}" placeholder="">
                                                @error('kin_suburb')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <input class="form-control" type="text" name="kin_state"
                                                    value="{{ old('kin_state') }}" placeholder="">
                                                @error('kin_state')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Postcode</label>
                                                <input class="form-control" type="text" name="kin_postcode"
                                                    value="{{ old('kin_postcode') }}" placeholder="">
                                                @error('kin_postcode')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Home Phone</label>
                                                <input type="hidden" value="{{ old('kin_phone_country_dialCode') }}"
                                                    id="kin_phone_country_dialCode" name="kin_phone_country_dialCode">
                                                <input type="hidden" value="{{ old('kin_phone_iso2') }}"
                                                    id="kin_phone_iso2" name="kin_phone_iso2">
                                                <input type="tel" id="kin_phone" name="kin_phone" value=""
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
                                                <input type="tel" id="kin_mobile" name="kin_mobile" value=""
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
                                                    value="{{ old('kin_work') }}" value="" class="form-control"
                                                    placeholder="">
                                                @error('work')
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
    </section>
@endsection
@section('js')
    <script src="{{ asset('js/wizard.js') }}"></script>
    <script>
        $(document).ready(function() {
            var input = document.querySelector("#phone");
            var itiphone = window.intlTelInput(input, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('phone_iso2') }}"
            });
            function getSelectedCountryDataMobile() {
                var countryData = itiphone.getSelectedCountryData();
                var countryDialCode = countryData.dialCode;
                if (countryDialCode) {
                    document.getElementById('phone_country_dialCode').value = countryDialCode;
                    document.getElementById('phone_iso2').value = countryData.iso2;
                }
                var oldPhoneNumber = "{{ old('phone') }}";
                if (oldPhoneNumber !== '') {
                    $('#phone').val(oldPhoneNumber);
                }
            }

            input.addEventListener("countrychange", function() {
                getSelectedCountryDataMobile();
            });
            getSelectedCountryDataMobile();

            var inputMobile = document.querySelector("#mobile");
            var itimobile = window.intlTelInput(inputMobile, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('mobile_iso2') }}"
            });

            function getSelectedCountryDatamobile() {
                var countryData = itimobile.getSelectedCountryData();
                var countryDialCode = countryData.dialCode;
                if (countryDialCode) {
                    document.getElementById('mobile_country_dialCode').value = countryDialCode;
                    document.getElementById('mobile_iso2').value = countryData.iso2;
                }
                var oldmobile = "{{ old('mobile') }}";
                if (oldmobile !== '') {
                    $('#mobile').val(oldmobile);
                }
            }
            inputMobile.addEventListener("countrychange", function() {
                getSelectedCountryDatamobile();
            });
            getSelectedCountryDatamobile();
            var inputcompany_phone = document.querySelector("#company_phone");
            var iticompany_phone = window.intlTelInput(inputcompany_phone, {
                separateDialCode: true,
                preferredCountries: ["AU"],
                initialCountry: "{{ old('company_phone_iso2') }}"
            });

            function getSelectedCountryDatacompany_phone() {
                var countryData = iticompany_phone.getSelectedCountryData();
                var countryDialCode = countryData.dialCode;
                if (countryDialCode) {
                    document.getElementById('company_phone_country_dialCode').value = countryDialCode;
                    document.getElementById('company_phone_iso2').value = countryData.iso2;
                }
                var oldcompany_phone = "{{ old('company_phone') }}";
                if (oldcompany_phone !== '') {
                    $('#company_phone').val(oldcompany_phone);
                }
            }
            inputcompany_phone.addEventListener("countrychange", function() {
                getSelectedCountryDatacompany_phone();
            });
            getSelectedCountryDatacompany_phone();
        });
        var input = document.querySelector("#kin_phone");
        var itikin_phone = window.intlTelInput(input, {
            separateDialCode: true,
            preferredCountries: ["AU"],
            initialCountry: "{{ old('kin_phone_iso2') }}"
        });

        function getSelectedCountryDataMobile() {
            var countryData = itikin_phone.getSelectedCountryData();
            var countryDialCode = countryData.dialCode;
            if (countryDialCode) {
                document.getElementById('kin_phone_country_dialCode').value = countryDialCode;
                document.getElementById('kin_phone_iso2').value = countryData.iso2;
            }
            var oldPhoneNumber = "{{ old('kin_phone') }}";
            if (oldPhoneNumber !== '') {
                $('#kin_phone').val(oldPhoneNumber);
            }
        }
        input.addEventListener("countrychange", function() {
            getSelectedCountryDataMobile();
        });
        getSelectedCountryDataMobile();

        var inputMobile = document.querySelector("#kin_mobile");
        var itikin_mobile = window.intlTelInput(inputMobile, {
            separateDialCode: true,
            preferredCountries: ["AU"],
            initialCountry: "{{ old('kin_mobile_iso2') }}"
        });

        function getSelectedCountryDatakin_mobile() {
            var countryData = itikin_mobile.getSelectedCountryData();
            var countryDialCode = countryData.dialCode;
            if (countryDialCode) {
                document.getElementById('kin_mobile_country_dialCode').value = countryDialCode;
                document.getElementById('kin_mobile_iso2').value = countryData.iso2;
            }

            var oldkin_mobile = "{{ old('kin_mobile') }}";
            if (oldkin_mobile !== '') {
                $('#kin_mobile').val(oldkin_mobile);
            }
        }
        inputMobile.addEventListener("countrychange", function() {
            getSelectedCountryDatakin_mobile();
        });
        getSelectedCountryDatakin_mobile();


    </script>

@endsection

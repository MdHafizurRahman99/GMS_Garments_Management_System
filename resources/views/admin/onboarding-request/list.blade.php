@extends('layouts.admin.master')
@section('title')
    Business Profile List
@endsection

@section('css')
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Add custom styles for table if needed */
        table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        tbody tr:nth-of-type(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <h1>Business Profile List</h1>
        <div class="table-responsive">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>SI No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        {{-- @if (Auth::user()->can('business.approve'))
                            <th>Status</th>
                        @endif --}}

                        {{-- @if (Auth::user()->can('business.edit') || Auth::user()->can('business.delete'))
                            <th>Action</th>
                        @endif --}}
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($requests as $request)
                        @php
                            $i++;
                        @endphp
                        <tr>
                            <td> {{ $i }} </td>
                            <td>{{ $request->first_name . ' ' . $request->last_name }}</td>
                            <td>{{ $request->email }}</td>
                            <td>{{ $request->phone }}</td>
                            {{-- @if (Auth::user()->can('business.approve'))
                                <td>{{ $business->status == '0' ? 'Not Approved' : 'Approved' }}
                                    @if ($business->status == '0')
                                        <a href="{{ route('business.status', ['business_id' => $business->id]) }}">
                                            <input class="btn btn-success mx-2" type="button" value="Approve"
                                                onclick="return confirm('Do you want to approve this Business Profile!')">
                                        </a>
                                    @else
                                        <a href="{{ route('business.status', ['business_id' => $business->id]) }}">
                                            <input class="btn btn-warning m-2" type="button" value="Disapprove"
                                                onclick="return confirm('Do you want to disapprove this Business Profile!')">
                                        </a>
                                    @endif
                                </td>
                            @endif
                            @if (Auth::user()->can('business.edit') || Auth::user()->can('business.delete'))
                                <td>
                                    @if (Auth::user()->can('business.edit'))
                                        <a href="{{ route('business.edit', ['business' => $business->id]) }}">
                                            <input class="btn btn-warning" type="button" value="Edit">
                                        </a>
                                    @endif

                                    @if (Auth::user()->can('business.delete'))
                                        <form action="{{ route('business.destroy', ['business' => $business->id]) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                                onclick="return confirm('Do you want to delete this Business Profile!')">
                                        </form>
                                    @endif

                                </td>
                            @endif --}}
                        </tr>
                    @endforeach

                </tbody>
            </table>
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
@endsection

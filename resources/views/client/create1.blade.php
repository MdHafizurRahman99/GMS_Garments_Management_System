<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .underline-text {
            text-decoration: underline;
        }
    </style>
    <title>Client Information</title>
</head>

<body class="bg-light p-4">
    <form class="container" action="{{ route('client.store') }}" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center font-weight-bold mb-4">Client Informations</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center font-weight-bold mb-4">GENERAL DETAILS</h2>
                        <div class="form-group">
                            <label for="exampleSelect">Business Structure</label>
                            <select class="form-control" name="business_structure" id="exampleSelect">
                                <option value="Other" {{ old('business_structure') == 'Other' ? 'selected' : '' }}>
                                    Other </option>
                                <option value="Partnership"
                                    {{ old('business_structure') == 'Partnership' ? 'selected' : '' }}>
                                    Partnership </option>
                                <option value="Self Managed Superannuation Form"
                                    {{ old('business_structure') == 'Self Managed Superannuation Form' ? 'selected' : '' }}>
                                    Self Managed Superannuation Form
                                </option>
                                <option value="Sole Trader"
                                    {{ old('business_structure') == 'Sole Trader' ? 'selected' : '' }}>Sole Trader
                                </option>
                                <option value="Superannuation Fund"
                                    {{ old('business_structure') == 'Superannuation Fund' ? 'selected' : '' }}>
                                    Superannuation Fund </option>
                                <option value="Trust" {{ old('business_structure') == 'Trust' ? 'selected' : '' }}>
                                    Trust </option>
                                <option value="Trust-state"
                                    {{ old('business_structure') == 'Trust-state' ? 'selected' : '' }}>Trust-state
                                </option>
                                <option value="Unit-Trust"
                                    {{ old('business_structure') == 'Unit-Trust' ? 'selected' : '' }}>Unit-Trust
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
                                <option value="Trust" {{ old('business_structure') == 'Trust' ? 'selected' : '' }}>
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


                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center font-weight-bold mb-4">CONTACT DETAILS</h2>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input required type="text" id="phone" name="phone"
                                    value="{{ old('phone') }}" class="form-control" placeholder="Enter Phone Number">
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="fax">Fax</label>
                                <input required type="text" id="fax" name="fax"
                                    value="{{ old('fax') }}" class="form-control" placeholder="Enter Fax">
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
                            <input required type="email" id="email" name="email" value="{{ old('email') }}"
                                class="form-control" placeholder="Enter Contact Email">
                            @error('email')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="website">Website</label>
                            <input required type="text" id="website" name="website" value="{{ old('website') }}"
                                class="form-control" placeholder="Website">
                            @error('website')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="website" class="underline-text font-weight-bold">Physical Address</label>
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
                                        value="{{ old('physical_city') }}" name="physical_city" class="form-control"
                                        placeholder="Enter Town/City">
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
                        <div class="form-group">
                            <label for="website" class="underline-text font-weight-bold">Postal Address</label>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="postal_street">Street</label>
                                    <input required type="text" id="postal_street"
                                        value="{{ old('postal_street') }}" name="postal_street" class="form-control"
                                        placeholder="Enter Street ">
                                    @error('postal_street')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postal_city">Town/City</label>
                                    <input required type="text" id="postal_city" value="{{ old('postal_city') }}"
                                        name="postal_city" class="form-control" placeholder="Enter Town/City">
                                    @error('postal_city')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="postal_state">State/Region</label>
                                    <input required type="text" id="postal_state"
                                        value="{{ old('postal_state') }}" name="postal_state" class="form-control"
                                        placeholder="Enter State/Region ">
                                    @error('postal_state')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postal_postal_code">Postal/Zip Code</label>
                                    <input required type="text" id="postal_postal_code"
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
                                    <input required type="text" id="postal_country" name="postal_country"
                                        value="{{ old('postal_country') }}" class="form-control"
                                        placeholder="Enter Country ">
                                    @error('postal_country')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        {{-- <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name1">Name:</label>
                                <input  required type="text" id="name1" name="name1" class="form-control"
                                    placeholder="Enter name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email1">Email:</label>
                                <input  required type="email" id="email1" name="email1" class="form-control"
                                    placeholder="Enter email">
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center font-weight-bold mb-4">TAX & COMPANY DETAILS</h2>
                        <div class="form-group">
                            <label for="tax_file_number">Tax File Number</label>
                            <input required type="text" id="tax_file_number" name="tax_file_number"
                                value="{{ old('tax_file_number') }}" class="form-control"
                                placeholder="Enter Tax File Number">
                            @error('tax_file_number')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="business_number">Australian Business Number/ With holding Payer Number</label>
                            <input required type="text" id="business_number" name="business_number"
                                value="{{ old('business_number') }}" class="form-control"
                                placeholder="Enter Australian Business Number/ Withholding Payer Number">
                            @error('business_number')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="company_number">Australian Company Number</label>
                            <input required type="text" id="company_number" name="company_number"
                                value="{{ old('company_number') }}" class="form-control"
                                placeholder="Enter Australian Company Number">
                            @error('company_number')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center font-weight-bold mb-4">BANK DETAILS</h2>
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
                                value="{{ old('financial_institution_name') }}" name="financial_institution_name"
                                class="form-control" placeholder="Enter Financial Instituion Name">
                            @error('financial_institution_name')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bsb_number">BSB Number</label>
                            <input required type="text" id="bsb_number" name="bsb_number" class="form-control"
                                value="{{ old('bsb_number') }}" placeholder="Enter BSB Number">
                            @error('bsb_number')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
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

                                    <input class="form-check-input" type="checkbox" name="tax_form" value="1"
                                        id="tax_form" {{ old('tax_form') ? 'checked' : '' }}>
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
                                    <input class="form-check-input" type="checkbox" name="ato_client" value="1"
                                        id="ato_client" {{ old('ato_client') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="gridCheck1">
                                        Active ATO Client </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            {{-- <div class="col-sm-4">Verification Document Provided</div> --}}
                            <div class="col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="verification_document"
                                        value="1" id="verification_document"
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
                                    {{ old('document_type') == 'Financial Documents' ? 'selected' : '' }}>Financial
                                    Documents </option>
                            </select>

                        </div>
                        {{-- <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-4 pt-0">Document Type</legend>
                                <div class="col-sm-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="document_type"
                                            id="document_type" value=".pdf" checked>
                                        <label class="form-check-label" for="document_type">
                                            .pdf
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="document_type"
                                            id="document_type" value=".docx">
                                        <label class="form-check-label" for="document_type">
                                            .docx
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset> --}}

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
</body>

</html>

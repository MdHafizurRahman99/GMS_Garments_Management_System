<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Business Profile List </title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
</head>

<body>

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
                        <th>Company Name</th>
                        <th>Company Type </th>
                        <th>Accountants</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($businesses as $business)
                        @php
                            $i++;
                        @endphp
                        <tr>
                            <td> {{ $i }} </td>
                            <td>{{ $business->company_name }}</td>
                            <td>{{ $business->company_type }}</td>
                            <td>{{ $business->accountants_number }}</td>
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
                            <td>
                                <a href="{{ route('business.edit', ['business' => $business->id]) }}">
                                    <input class="btn btn-warning" type="button" value="Edit">
                                </a>

                                <form action="{{ route('business.destroy', ['business' => $business->id]) }}"
                                    method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                        onclick="return confirm('Do you want to delete this Business Profile!')">
                                </form>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS (optional for some functionalities) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

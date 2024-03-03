<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Client List</title>
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
        <h1>Client List</h1>
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
                        <th>Business Structure </th>
                        <th>Client Type </th>
                        <th>Full Legal Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($clients as $client)
                        @php
                            $i++;
                        @endphp
                        <tr>
                            <td> {{ $i }} </td>
                            <td>{{ $client->business_structure }}</td>
                            <td>{{ $client->client_type }}</td>
                            <td>{{ $client->full_legal_name }}</td>
                            <td>{{ $client->status == '0' ? 'Not Approved' : 'Approved' }}
                                @if ($client->status == '0')
                                    <a href="{{ route('client.status', ['client_id' => $client->id]) }}">
                                        <input class="btn btn-success mx-2" type="button" value="Approve"
                                            onclick="return confirm('Do you want to approve this client!')">
                                    </a>
                                @else
                                    <a href="{{ route('client.status', ['client_id' => $client->id]) }}">
                                        <input class="btn btn-warning m-2" type="button" value="Disapprove"
                                            onclick="return confirm('Do you want to disapprove this client!')">
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('client.edit', ['client' => $client->id]) }}">
                                    <input class="btn btn-warning" type="button" value="Edit">
                                </a>

                                <form action="{{ route('client.destroy', ['client' => $client->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input class="my-2 btn btn-danger" type="submit" value="Delete"
                                        onclick="return confirm('Do you want to delete this client request!')">
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1 class="mb-4">User List</h1>
        <a href="{{ route('index') }}" class="btn btn-secondary mb-3">Back Home</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Unique ID</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->unique_id }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>
                            @if ($user->status == 'checked')
                                <a class="btn btn-sm btn-primary">{{ $user->status }}</a>
                            @else
                                <a class="btn btn-sm btn-danger">{{ $user->status }}</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('invoice', $user->id) }}" class="btn btn-secondary">View Invoice</a>
                        </td>
                    </tr>
                @endforeach


                <!-- Add more users as needed -->
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

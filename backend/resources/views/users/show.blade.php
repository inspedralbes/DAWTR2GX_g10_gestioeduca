<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User View</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>User Details</h1>
        <div class="card">
            <div class="card-body">
                <p class="card-title"><strong>Nombre:</strong> {{ $user->name }}</p>
                <p><strong>Apellido:</strong> {{ $user->last_name}}</p>
                <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="card-text"><strong>Created At:</strong> {{ $user->created_at }}</p>
                <p class="card-text"><strong>Updated At:</strong> {{ $user->updated_at }}</p>
            </div>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-primary mt-3">Back to Users List</a>
    </div>
</body>
</html>

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>User Details</h1>
    <div class="card mb-3">
        <div class="card-body">
            <!-- Icono de avatar -->
            <div class="form-group mb-3 text-center">
                <i class="fas fa-user-circle fa-5x"></i>
            </div>

            <div class="form-group mb-3">
                <label for="name"><strong>Name:</strong></label>
                <p>{{ $user->name }}</p>
            </div>
            <div class="form-group mb-3">
                <label for="last_name"><strong>Last Name:</strong></label>
                <p>{{ $user->last_name }}</p>
            </div>
            <div class="form-group mb-3">
                <label for="email"><strong>Email:</strong></label>
                <p>{{ $user->email }}</p>
            </div>
            <div class="form-group mb-3">
                <label for="created_at"><strong>Created At:</strong></label>
                <p>{{ $user->created_at }}</p>
            </div>
            <div class="form-group mb-3">
                <label for="updated_at"><strong>Updated At:</strong></label>
                <p>{{ $user->updated_at }}</p>
            </div>
        </div>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-primary w-100 mt-3">Back to Users List</a>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Users</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add New User</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role ? $user->role->name : 'No role assigned' }}</td>

                <td>
                    <!-- View button -->
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">View</a>
                    
                    <!-- Edit button -->
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Delete button -->
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No users found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Boton de vovler al dashboard -->
    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3 w-100">Back to Dashboard</a>
</div>
@endsection

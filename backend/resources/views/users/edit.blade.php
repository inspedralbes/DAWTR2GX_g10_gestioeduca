@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="image">Image URL</label>
            <input type="text" id="image" name="image" value="{{ old('image', $user->image) }}" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="role_id">Role</label>
            <select name="role_id" id="role_id" class="form-control">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3 w-100">Update</button>
    </form>
    <a href="{{ route('users.index') }}" class="btn btn-primary mt-3 w-100">Back to Users List</a>
</div>
@endsection

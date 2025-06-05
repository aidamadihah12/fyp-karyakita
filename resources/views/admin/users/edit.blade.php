@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="container">
    <h2>Edit User #{{ $user->id }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $user->full_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="user_role" class="form-label">Role</label>
            <select name="user_role" id="user_role" class="form-select" required>
                <option value="Admin" {{ old('user_role', $user->user_role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Staff" {{ old('user_role', $user->user_role) == 'Staff' ? 'selected' : '' }}>Staff</option>
                <option value="Freelance" {{ old('user_role', $user->user_role) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update User</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>
@endsection

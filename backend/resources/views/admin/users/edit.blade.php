@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <section class="hero">
        <h1>Edit User</h1>
        <p>Update profile details, access role, and active status.</p>
    </section>

    <section class="panel" style="margin: 1rem 0 2rem;">
        <form class="card-form" method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')
            <label>
                Name
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </label>
            <label>
                Email
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </label>
            <label>
                Role
                <select name="role" required>
                    <option value="student" @selected(old('role', $user->role) === 'student')>Student</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                </select>
            </label>
            <label style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="is_active" value="1" style="width:auto;" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                Active account
            </label>
            <label>
                New password (optional)
                <input type="password" name="password">
            </label>
            <label>
                Confirm new password
                <input type="password" name="password_confirmation">
            </label>
            <div class="actions">
                <button class="pill pill-primary" type="submit">Update user</button>
                <a class="pill" href="{{ route('admin.users.index') }}">Back</a>
            </div>
        </form>
    </section>
@endsection

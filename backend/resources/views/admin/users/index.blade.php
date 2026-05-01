@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <section class="hero">
        <h1>User Management</h1>
        <p>Manage accounts, assign admin role, and control active/inactive status.</p>
    </section>

    <section class="actions" style="margin: 1rem 0;">
        <a class="pill" href="{{ route('admin.dashboard') }}">Back to dashboard</a>
    </section>

    <section class="panel" style="margin-bottom: 2rem;">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role === 'admin')
                                <span class="badge">Admin</span>
                            @else
                                <span class="badge tag-warning">Student</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->is_active)
                                <span class="badge tag-success">Active</span>
                            @else
                                <span class="badge tag-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="actions">
                            <a class="pill" href="{{ route('admin.users.edit', $user) }}">Edit</a>
                            @if (! auth()->user()->is($user))
                                <form class="inline" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="pill" type="submit">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 1rem;">{{ $users->links() }}</div>
    </section>
@endsection

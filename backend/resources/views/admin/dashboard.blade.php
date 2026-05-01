@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <section class="hero">
        <h1>Admin Dashboard</h1>
        <p>Manage users, articles, and protected library files from a single control panel.</p>
    </section>

    <section style="margin: 1rem 0;" class="actions">
        <a class="pill" href="{{ route('admin.users.index') }}">Manage Users</a>
        <a class="pill" href="{{ route('admin.articles.index') }}">Manage Articles</a>
        <a class="pill" href="{{ route('admin.library.index') }}">Manage PDF Library</a>
        <a class="pill pill-primary" href="{{ route('admin.guide') }}">Admin User Guide</a>
    </section>

    <section class="stats" style="margin-bottom: 2rem;">
        <div class="stat">
            <div class="muted">Users</div>
            <div class="value">{{ $usersCount }}</div>
            <div class="muted">Active: {{ $activeUsersCount }}</div>
        </div>
        <div class="stat">
            <div class="muted">Articles</div>
            <div class="value">{{ $articlesCount }}</div>
            <div class="muted">Pinned: {{ $pinnedArticlesCount }}</div>
        </div>
        <div class="stat">
            <div class="muted">Library</div>
            <div class="value">{{ $libraryFilesCount }}</div>
            <div class="muted">Total downloads: {{ $downloadsCount }}</div>
        </div>
    </section>
@endsection

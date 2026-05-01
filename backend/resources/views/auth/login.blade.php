@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <section class="hero">
        <h1>Login to Access Member Library</h1>
        <p>Registered students and approved users can download library PDFs securely.</p>
    </section>

    <section class="panel" style="max-width: 520px; margin: 1rem auto 2rem;">
        <form class="card-form" method="POST" action="{{ route('login.perform') }}">
            @csrf
            <label>
                Email
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
            <label>
                Password
                <input type="password" name="password" required>
            </label>
            <label style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="remember" value="1" style="width:auto;">
                Remember me
            </label>
            <div class="actions">
                <button class="pill pill-primary" type="submit">Login</button>
                <a class="pill" href="{{ route('register') }}">Create account</a>
            </div>
        </form>
    </section>
@endsection

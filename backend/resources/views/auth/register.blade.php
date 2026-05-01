@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <section class="hero">
        <h1>Create Your Library Account</h1>
        <p>Registration gives you access to members-only PDF downloads and community features.</p>
    </section>

    <section class="panel" style="max-width: 560px; margin: 1rem auto 2rem;">
        <form class="card-form" method="POST" action="{{ route('register.perform') }}">
            @csrf
            <label>
                Full name
                <input type="text" name="name" value="{{ old('name') }}" required>
            </label>
            <label>
                Email
                <input type="email" name="email" value="{{ old('email') }}" required>
            </label>
            <label>
                Password
                <input type="password" name="password" required>
            </label>
            <label>
                Confirm password
                <input type="password" name="password_confirmation" required>
            </label>
            <div class="actions">
                <button class="pill pill-primary" type="submit">Register</button>
                <a class="pill" href="{{ route('login') }}">Already registered?</a>
            </div>
        </form>
    </section>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'University Community Library')</title>
    <link rel="stylesheet" href="{{ asset('styles/app.css') }}">
</head>
<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <a class="brand" href="{{ route('home') }}">University Community Library</a>
            <nav class="nav-links">
                <a class="pill" href="{{ route('home') }}">Home</a>
                @auth
                    @if (auth()->user()->isAdmin())
                        <a class="pill" href="{{ route('admin.dashboard') }}">Admin</a>
                    @endif
                    <form class="inline" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="pill" type="submit">Logout</button>
                    </form>
                @else
                    <a class="pill" href="{{ route('login') }}">Login</a>
                    <a class="pill pill-primary" href="{{ route('register') }}">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container">
        @if (session('status'))
            <div class="flash flash-success">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="flash flash-error">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="flash flash-error">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>

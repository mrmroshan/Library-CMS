@extends('layouts.app')

@section('title', 'Admin User Guide')

@section('content')
    <section class="hero">
        <h1>Admin User Guide</h1>
        <p>
            This guide explains daily operations for managing users, articles, and the protected PDF library.
        </p>
    </section>

    <section class="panel" style="margin-top: 1rem; margin-bottom: 2rem;">
        <h2>1) Login and Dashboard</h2>
        <div class="cards">
            <div class="card">
                <p class="excerpt">
                    Login with your admin account, then open the <strong>Admin Dashboard</strong> from the top navigation.
                    The dashboard shows total users, articles, library files, and download counts.
                </p>
            </div>
        </div>

        <h2 style="margin-top: 1.2rem;">2) Manage PDF Categories</h2>
        <div class="cards">
            <div class="card">
                <p class="excerpt">
                    Go to <strong>Manage PDF Library</strong>. In the category section, add categories such as
                    Medical, Science, Engineering, or General. Categories appear on the homepage as filters.
                </p>
                <p class="excerpt">
                    You can remove a category only if no books are currently assigned to it.
                </p>
            </div>
        </div>

        <h2 style="margin-top: 1.2rem;">3) Upload and Manage Books (PDFs)</h2>
        <div class="cards">
            <div class="card">
                <p class="excerpt">
                    In <strong>Manage PDF Library</strong>, upload a PDF with title, category, author, and description.
                    A thumbnail is generated automatically.
                </p>
                <p class="excerpt">
                    - Use <strong>Hide</strong> to temporarily remove a book from public view.<br>
                    - Use <strong>Remove</strong> to permanently delete the book.<br>
                    - Keep <strong>Visible</strong> ON for books that should appear in library listings.
                </p>
            </div>
        </div>

        <h2 style="margin-top: 1.2rem;">4) Manage Articles</h2>
        <div class="cards">
            <div class="card">
                <p class="excerpt">
                    In <strong>Manage Articles</strong>, create news and useful content for visitors and registered users.
                    Use <strong>Pin on top</strong> for important announcements.
                </p>
                <p class="excerpt">
                    Use Draft (not published) for internal preparation and Publish when ready.
                </p>
            </div>
        </div>

        <h2 style="margin-top: 1.2rem;">5) Manage Users</h2>
        <div class="cards">
            <div class="card">
                <p class="excerpt">
                    In <strong>Manage Users</strong>, update user details, set role (<strong>Admin</strong> or
                    <strong>Student</strong>), and activate/deactivate accounts.
                </p>
                <p class="excerpt">
                    Best practice: keep admin access limited to trusted staff only.
                </p>
            </div>
        </div>

        <h2 style="margin-top: 1.2rem;">6) Public Experience Check</h2>
        <div class="cards">
            <div class="card">
                <p class="excerpt">
                    After updates, review the homepage:
                    - Category chips should filter books correctly.<br>
                    - Book tiles should display consistent cover sizing.<br>
                    - Non-logged users should see "Login to download".<br>
                    - Logged-in users should see "Download PDF".
                </p>
            </div>
        </div>

        <h2 style="margin-top: 1.2rem;">7) Routine Admin Checklist</h2>
        <div class="cards">
            <div class="card">
                <p class="excerpt">
                    Daily/weekly:
                    - Add new books and assign proper categories.<br>
                    - Hide outdated resources and remove duplicates.<br>
                    - Pin only urgent articles to keep homepage clean.<br>
                    - Review user accounts and deactivate suspicious accounts.
                </p>
            </div>
        </div>

        <div class="actions" style="margin-top: 1rem;">
            <a class="pill" href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
        </div>
    </section>
@endsection

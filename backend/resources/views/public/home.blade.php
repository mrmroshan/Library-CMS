@extends('layouts.app')

@section('title', 'Community & Library')

@section('content')
    <section class="hero">
        <h1>University Community Hub</h1>
        <p>
            Read public articles, announcements, and campus stories. Library PDFs are available for registered users only,
            with secure download tracking.
        </p>
    </section>

    <section class="panel" style="margin-top: 1rem;">
        <h2>Browse Library by Category</h2>
        <div class="actions">
            <a class="pill {{ $selectedCategory ? '' : 'pill-primary' }}" href="{{ route('home') }}">All Categories</a>
            @foreach ($categories as $category)
                <a
                    class="pill {{ $selectedCategory && $selectedCategory->is($category) ? 'pill-primary' : '' }}"
                    href="{{ route('home', ['category' => $category->slug]) }}"
                >
                    {{ $category->name }} ({{ $category->library_files_count }})
                </a>
            @endforeach
        </div>
    </section>

    <section class="panel" style="margin-top: 1rem;">
        <h2>Latest Articles</h2>
        <div class="cards">
            @forelse ($articles as $article)
                <article class="card">
                    <div class="actions" style="justify-content: space-between;">
                        <h3>
                            <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                        </h3>
                        @if ($article->is_pinned)
                            <span class="badge">Pinned</span>
                        @endif
                    </div>
                    <div class="meta">
                        By {{ $article->author->name }} |
                        {{ optional($article->published_at)->format('M d, Y') ?? 'Draft' }}
                    </div>
                    @if ($article->excerpt)
                        <p class="excerpt">{{ $article->excerpt }}</p>
                    @endif
                </article>
            @empty
                <p class="muted">No published articles yet.</p>
            @endforelse
        </div>
        <div style="margin-top: 1rem;">{{ $articles->links() }}</div>
    </section>

    <section class="panel" style="margin-top: 1rem; margin-bottom: 2rem;">
        <h2>
            Library Catalog
            @if ($selectedCategory)
                - {{ $selectedCategory->name }}
            @endif
        </h2>

        <div class="book-grid">
            @forelse ($libraryFiles as $file)
                <article class="book-tile">
                    <div class="book-cover-wrap">
                        <img class="book-cover" src="{{ $file->thumbnail_url }}" alt="{{ $file->title }} cover">
                        <div class="book-popup">
                            <img class="book-popup-image" src="{{ $file->thumbnail_url }}" alt="{{ $file->title }} enlarged cover">
                        </div>
                    </div>
                    <div class="book-content">
                        <h3 class="book-title">{{ $file->title }}</h3>
                        <div class="meta book-meta">{{ $file->author ?: 'Unknown author' }}</div>
                        <div class="meta book-meta">{{ $file->category?->name ?? 'Uncategorized' }}</div>
                        @if ($file->description)
                            <p class="excerpt book-excerpt">{{ \Illuminate\Support\Str::limit($file->description, 120) }}</p>
                        @endif
                        <div class="book-actions">
                            @auth
                                <a class="pill pill-primary" href="{{ route('library.download', $file) }}">Download PDF</a>
                            @else
                                <a class="pill" href="{{ route('login') }}">Login to download</a>
                            @endauth
                        </div>
                    </div>
                </article>
            @empty
                <p class="muted">No library files available yet.</p>
            @endforelse
        </div>

        <div style="margin-top: 1rem;">{{ $libraryFiles->links() }}</div>
    </section>
@endsection

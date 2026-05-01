@extends('layouts.app')

@section('title', 'Manage Articles')

@section('content')
    <section class="hero">
        <h1>Manage Articles</h1>
        <p>Create public content for visitors and registered users. Pin critical articles to keep them on top.</p>
    </section>

    <section class="actions" style="margin: 1rem 0;">
        <a class="pill pill-primary" href="{{ route('admin.articles.create') }}">Create article</a>
        <a class="pill" href="{{ route('admin.dashboard') }}">Back to dashboard</a>
    </section>

    <section class="panel" style="margin-bottom: 2rem;">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($articles as $article)
                    <tr>
                        <td>
                            <strong>{{ $article->title }}</strong>
                            <div class="meta">{{ $article->slug }}</div>
                        </td>
                        <td>{{ $article->author->name }}</td>
                        <td>
                            @if ($article->is_published)
                                <span class="badge tag-success">Published</span>
                            @else
                                <span class="badge tag-warning">Draft</span>
                            @endif
                            @if ($article->is_pinned)
                                <span class="badge">Pinned</span>
                            @endif
                        </td>
                        <td class="actions">
                            <a class="pill" href="{{ route('admin.articles.edit', $article) }}">Edit</a>
                            <form class="inline" method="POST" action="{{ route('admin.articles.destroy', $article) }}">
                                @csrf
                                @method('DELETE')
                                <button class="pill" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="muted">No articles yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 1rem;">{{ $articles->links() }}</div>
    </section>
@endsection

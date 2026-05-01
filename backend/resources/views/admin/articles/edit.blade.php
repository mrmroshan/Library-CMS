@extends('layouts.app')

@section('title', 'Edit Article')

@section('content')
    <section class="hero">
        <h1>Edit Article</h1>
        <p>Update article text, visibility, and pin status.</p>
    </section>

    <section class="panel" style="margin: 1rem 0 2rem;">
        <form class="card-form" method="POST" action="{{ route('admin.articles.update', $article) }}">
            @csrf
            @method('PUT')
            <label>
                Title
                <input type="text" name="title" value="{{ old('title', $article->title) }}" required>
            </label>
            <label>
                Excerpt
                <textarea name="excerpt" style="min-height: 90px;">{{ old('excerpt', $article->excerpt) }}</textarea>
            </label>
            <label>
                Content
                <textarea name="content" required>{{ old('content', $article->content) }}</textarea>
            </label>
            <label style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="is_published" value="1" style="width:auto;" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                Published
            </label>
            <label style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="is_pinned" value="1" style="width:auto;" {{ old('is_pinned', $article->is_pinned) ? 'checked' : '' }}>
                Pin on top
            </label>
            <div class="actions">
                <button class="pill pill-primary" type="submit">Update article</button>
                <a class="pill" href="{{ route('admin.articles.index') }}">Back</a>
            </div>
        </form>
    </section>
@endsection

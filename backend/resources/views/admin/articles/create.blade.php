@extends('layouts.app')

@section('title', 'Create Article')

@section('content')
    <section class="hero">
        <h1>Create Article</h1>
        <p>Publish updates for visitors and members. Pinned articles appear first on the homepage.</p>
    </section>

    <section class="panel" style="margin: 1rem 0 2rem;">
        <form class="card-form" method="POST" action="{{ route('admin.articles.store') }}">
            @csrf
            <label>
                Title
                <input type="text" name="title" value="{{ old('title') }}" required>
            </label>
            <label>
                Excerpt
                <textarea name="excerpt" style="min-height: 90px;">{{ old('excerpt') }}</textarea>
            </label>
            <label>
                Content
                <textarea name="content" required>{{ old('content') }}</textarea>
            </label>
            <label style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="is_published" value="1" style="width:auto;" {{ old('is_published', '1') ? 'checked' : '' }}>
                Publish now
            </label>
            <label style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="is_pinned" value="1" style="width:auto;" {{ old('is_pinned') ? 'checked' : '' }}>
                Pin on top
            </label>
            <div class="actions">
                <button class="pill pill-primary" type="submit">Save article</button>
                <a class="pill" href="{{ route('admin.articles.index') }}">Cancel</a>
            </div>
        </form>
    </section>
@endsection

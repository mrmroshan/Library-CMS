@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <section class="hero">
        <h1>{{ $article->title }}</h1>
        <p>
            By {{ $article->author->name }}
            @if ($article->published_at)
                | {{ $article->published_at->format('M d, Y') }}
            @endif
            @if ($article->is_pinned)
                | Pinned article
            @endif
        </p>
    </section>

    <article class="panel" style="margin: 1rem 0 2rem;">
        <div style="white-space: pre-wrap; line-height: 1.65;">{{ $article->content }}</div>
    </article>
@endsection

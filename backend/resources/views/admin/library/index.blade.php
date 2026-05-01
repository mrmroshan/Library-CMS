@extends('layouts.app')

@section('title', 'Manage PDF Library')

@section('content')
    <section class="hero">
        <h1>PDF Library Management</h1>
        <p>
            Upload, hide, or remove protected PDFs. Current provider: <strong>{{ strtoupper(str_replace('_', ' ', $storageProvider)) }}</strong>.
            Local storage is active by default until cloud confirmation.
        </p>
    </section>

    <section class="grid" style="margin-top: 1rem;">
        <div class="panel">
            <h2>Upload PDF</h2>
            <form class="card-form" method="POST" action="{{ route('admin.library.store') }}" enctype="multipart/form-data">
                @csrf
                <label>
                    Title
                    <input type="text" name="title" value="{{ old('title') }}" required>
                </label>
                <label>
                    Category
                    <select name="category_id" required>
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((int) old('category_id') === $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </label>
                <label>
                    Author
                    <input type="text" name="author" value="{{ old('author') }}">
                </label>
                <label>
                    Description
                    <textarea name="description" style="min-height: 100px;">{{ old('description') }}</textarea>
                </label>
                <label>
                    PDF file
                    <input type="file" name="pdf" accept="application/pdf" required>
                </label>
                <p class="meta">Maximum upload size: {{ $uploadLimitMb }} MB</p>
                <label style="display:flex; align-items:center; gap:8px;">
                    <input type="checkbox" name="is_visible" value="1" style="width:auto;" {{ old('is_visible', '1') ? 'checked' : '' }}>
                    Visible in public library list
                </label>
                <button class="pill pill-primary" type="submit">Upload PDF</button>
            </form>
        </div>

        <div class="panel">
            <h2>Manage Categories</h2>
            <form class="card-form" method="POST" action="{{ route('admin.library.categories.store') }}">
                @csrf
                <label>
                    New category name
                    <input type="text" name="name" placeholder="e.g. Medical Research" required>
                </label>
                <button class="pill pill-primary" type="submit">Add Category</button>
            </form>

            <div class="cards" style="margin-top: 1rem;">
                @forelse ($categories as $category)
                    <div class="card">
                        <div class="actions" style="justify-content: space-between;">
                            <strong>{{ $category->name }}</strong>
                            <form class="inline" method="POST" action="{{ route('admin.library.categories.destroy', $category) }}">
                                @csrf
                                @method('DELETE')
                                <button class="pill" type="submit">Remove</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="muted">No categories defined.</p>
                @endforelse
            </div>
        </div>

        <div class="panel">
            <h2>Current Files</h2>
            <div class="cards">
                @forelse ($files as $file)
                    <div class="card">
                        <img src="{{ $file->thumbnail_url }}" alt="{{ $file->title }} cover" style="width: 90px; height: 130px; object-fit: cover; border-radius: 8px; border: 1px solid #dbe3f2;">
                        <h3>{{ $file->title }}</h3>
                        <div class="meta">
                            By {{ $file->author ?: 'Unknown' }} | Uploaded by {{ $file->uploader->name }}
                        </div>
                        <div class="meta">Category: {{ $file->category?->name ?? 'Uncategorized' }}</div>
                        <div class="meta">{{ strtoupper(str_replace('_', ' ', $file->storage_provider)) }} | {{ number_format($file->file_size / 1024, 1) }} KB</div>
                        <div class="actions" style="margin-top: 0.6rem;">
                            <form class="inline" method="POST" action="{{ route('admin.library.toggle-visibility', $file) }}">
                                @csrf
                                @method('PATCH')
                                <button class="pill" type="submit">{{ $file->is_visible ? 'Hide' : 'Show' }}</button>
                            </form>
                            <form class="inline" method="POST" action="{{ route('admin.library.destroy', $file) }}">
                                @csrf
                                @method('DELETE')
                                <button class="pill" type="submit">Remove</button>
                            </form>
                            @if ($file->is_visible)
                                <span class="badge tag-success">Visible</span>
                            @else
                                <span class="badge tag-danger">Hidden</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="muted">No library files yet.</p>
                @endforelse
            </div>
            <div style="margin-top: 1rem;">{{ $files->links() }}</div>
        </div>
    </section>
@endsection

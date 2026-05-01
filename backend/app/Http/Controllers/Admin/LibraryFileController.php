<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryCategory;
use App\Models\LibraryFile;
use App\Services\BookThumbnailService;
use App\Services\LibraryStorageManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class LibraryFileController extends Controller
{
    public function index()
    {
        $files = LibraryFile::query()
            ->with(['uploader', 'category'])
            ->orderByDesc('id')
            ->paginate(12);

        return view('admin.library.index', [
            'files' => $files,
            'categories' => LibraryCategory::query()->orderBy('name')->get(),
            'storageProvider' => config('library.storage_provider', 'local'),
        ]);
    }

    public function store(Request $request, LibraryStorageManager $storageManager, BookThumbnailService $thumbnailService)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category_id' => ['required', 'exists:library_categories,id'],
            'description' => ['nullable', 'string', 'max:500'],
            'author' => ['nullable', 'string', 'max:120'],
            'pdf' => ['required', 'file', 'mimetypes:application/pdf', 'max:30720'],
            'is_visible' => ['nullable', 'boolean'],
        ]);

        try {
            $stored = $storageManager->storeUploadedPdf($request->file('pdf'));
        } catch (RuntimeException $exception) {
            return back()->with('error', $exception->getMessage())->withInput();
        }

        $selectedCategory = LibraryCategory::query()->find($data['category_id']);
        $thumbnailPath = null;
        if ($stored['provider'] === 'local') {
            $disk = (string) config('library.providers.local.disk', 'local');
            $absolutePdfPath = Storage::disk($disk)->path($stored['path']);
            $thumbnailPath = $thumbnailService->generate($absolutePdfPath, $data['title'], $selectedCategory?->name);
        }

        LibraryFile::query()->create([
            'uploaded_by' => $request->user()->id,
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'author' => $data['author'] ?? null,
            'storage_provider' => $stored['provider'],
            'storage_path' => $stored['path'],
            'thumbnail_path' => $thumbnailPath,
            'external_file_id' => $stored['external_id'],
            'file_size' => $stored['size'],
            'is_visible' => (bool) ($data['is_visible'] ?? false),
        ]);

        return redirect()->route('admin.library.index')->with('status', 'PDF uploaded successfully.');
    }

    public function toggleVisibility(LibraryFile $libraryFile)
    {
        $libraryFile->update(['is_visible' => ! $libraryFile->is_visible]);
        return redirect()->route('admin.library.index')->with('status', 'Visibility updated.');
    }

    public function destroy(LibraryFile $libraryFile, LibraryStorageManager $storageManager, BookThumbnailService $thumbnailService)
    {
        $storageManager->deleteFile($libraryFile);
        $thumbnailService->delete($libraryFile->thumbnail_path);
        $libraryFile->delete();

        return redirect()->route('admin.library.index')->with('status', 'PDF removed.');
    }
}

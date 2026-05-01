<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\DownloadLog;
use App\Models\LibraryCategory;
use App\Models\LibraryFile;
use App\Services\LibraryStorageManager;
use Illuminate\Http\Request;
use Throwable;

class PublicController extends Controller
{
    public function home(Request $request)
    {
        $selectedCategory = null;

        $categories = LibraryCategory::query()
            ->withCount(['libraryFiles' => fn ($query) => $query->visible()])
            ->orderBy('name')
            ->get();

        $libraryFilesQuery = LibraryFile::query()
            ->visible()
            ->with('category');

        if ($request->filled('category')) {
            $selectedCategory = LibraryCategory::query()
                ->where('slug', (string) $request->query('category'))
                ->first();

            if ($selectedCategory) {
                $libraryFilesQuery->where('category_id', $selectedCategory->id);
            }
        }

        $articles = Article::query()
            ->published()
            ->with('author')
            ->paginate(8)
            ->withQueryString();

        $libraryFiles = $libraryFilesQuery
            ->paginate(8, ['*'], 'library_page')
            ->withQueryString();

        return view('public.home', compact('articles', 'libraryFiles', 'categories', 'selectedCategory'));
    }

    public function showArticle(string $slug)
    {
        $article = Article::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->with('author')
            ->firstOrFail();

        return view('public.article', compact('article'));
    }

    public function downloadLibraryFile(Request $request, LibraryFile $libraryFile, LibraryStorageManager $storageManager)
    {
        if (! $request->user()) {
            return redirect()->route('login')->with('error', 'Please login to download library files.');
        }

        abort_unless($libraryFile->is_visible, 404);

        DownloadLog::query()->create([
            'user_id' => $request->user()->id,
            'library_file_id' => $libraryFile->id,
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        try {
            return $storageManager->downloadResponse($libraryFile);
        } catch (Throwable $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}

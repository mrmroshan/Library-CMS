<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LibraryCategoryController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:library_categories,name'],
        ]);

        $baseSlug = Str::slug($data['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (LibraryCategory::query()->where('slug', $slug)->exists()) {
            $counter++;
            $slug = "{$baseSlug}-{$counter}";
        }

        LibraryCategory::query()->create([
            'name' => $data['name'],
            'slug' => $slug,
        ]);

        return redirect()->route('admin.library.index')->with('status', 'Category created.');
    }

    public function destroy(LibraryCategory $libraryCategory)
    {
        if ($libraryCategory->libraryFiles()->exists()) {
            return back()->with('error', 'Cannot delete category with existing PDF files.');
        }

        $libraryCategory->delete();
        return redirect()->route('admin.library.index')->with('status', 'Category removed.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\DownloadLog;
use App\Models\LibraryFile;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'usersCount' => User::query()->count(),
            'activeUsersCount' => User::query()->where('is_active', true)->count(),
            'articlesCount' => Article::query()->count(),
            'pinnedArticlesCount' => Article::query()->where('is_pinned', true)->count(),
            'libraryFilesCount' => LibraryFile::query()->count(),
            'downloadsCount' => DownloadLog::query()->count(),
        ]);
    }

    public function guide()
    {
        return view('admin.guide');
    }
}

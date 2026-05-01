<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\LibraryCategory;
use App\Models\LibraryFile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@university.local'],
            [
                'name' => 'System Admin',
                'password' => 'admin12345',
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $student = User::query()->firstOrCreate(
            ['email' => 'student@university.local'],
            [
                'name' => 'Student User',
                'password' => 'student12345',
                'role' => 'student',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $title = 'Welcome to the University Community Portal';
        Article::query()->firstOrCreate([
            'slug' => Str::slug($title),
        ], [
            'author_id' => $admin->id,
            'title' => $title,
            'excerpt' => 'A quick guide to public articles and members-only library resources.',
            'content' => "This portal provides public community content and secure PDF access for registered users.\n\nAdmins can publish pinned announcements and manage library files through the dashboard.",
            'is_published' => true,
            'is_pinned' => true,
            'published_at' => now(),
        ]);

        $generalCategory = LibraryCategory::query()->firstOrCreate([
            'slug' => 'general',
        ], [
            'name' => 'General',
        ]);

        LibraryCategory::query()->firstOrCreate([
            'slug' => 'science',
        ], [
            'name' => 'Science',
        ]);

        LibraryCategory::query()->firstOrCreate([
            'slug' => 'medical',
        ], [
            'name' => 'Medical',
        ]);

        LibraryFile::query()->firstOrCreate([
            'title' => 'Library Access Guide',
        ], [
            'uploaded_by' => $admin->id,
            'category_id' => $generalCategory->id,
            'description' => 'Sample metadata record. Upload real PDFs from Admin > PDF Library Management.',
            'author' => 'Library Office',
            'storage_provider' => 'local',
            'storage_path' => 'library/sample-guide.pdf',
            'file_size' => 0,
            'is_visible' => false,
        ]);
    }
}

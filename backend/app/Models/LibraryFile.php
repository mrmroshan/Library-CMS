<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LibraryFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'uploaded_by',
        'category_id',
        'title',
        'description',
        'author',
        'storage_provider',
        'storage_path',
        'thumbnail_path',
        'external_file_id',
        'file_size',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
        ];
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LibraryCategory::class, 'category_id');
    }

    public function downloadLogs(): HasMany
    {
        return $this->hasMany(DownloadLog::class);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true)->orderByDesc('id');
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail_path ? asset(ltrim($this->thumbnail_path, '/')) : asset('book-cover-placeholder.svg');
    }
}

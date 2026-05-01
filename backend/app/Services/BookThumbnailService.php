<?php

namespace App\Services;

use Illuminate\Support\Str;
use RuntimeException;
use Throwable;

class BookThumbnailService
{
    public function generate(string $pdfAbsolutePath, string $title, ?string $category = null): string
    {
        $directory = public_path('book-thumbnails');

        if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
            throw new RuntimeException('Could not create thumbnail directory.');
        }

        // Try real first-page preview when Imagick/Ghostscript are available.
        if (class_exists(\Imagick::class)) {
            try {
                $filename = Str::uuid().'.jpg';
                $absoluteTarget = $directory.DIRECTORY_SEPARATOR.$filename;

                $imagick = new \Imagick();
                $imagick->setResolution(150, 150);
                $imagick->readImage($pdfAbsolutePath.'[0]');
                $imagick->setImageFormat('jpeg');
                $imagick->thumbnailImage(320, 460, true, true);
                $imagick->writeImage($absoluteTarget);
                $imagick->clear();
                $imagick->destroy();

                return '/book-thumbnails/'.$filename;
            } catch (Throwable) {
                // Fall through to generated cover.
            }
        }

        return $this->generateFallbackCover($directory, $title, $category);
    }

    public function delete(?string $thumbnailPath): void
    {
        if (! $thumbnailPath) {
            return;
        }

        $normalized = ltrim($thumbnailPath, '/');
        $absolute = public_path($normalized);

        if (is_file($absolute)) {
            @unlink($absolute);
        }
    }

    private function generateFallbackCover(string $directory, string $title, ?string $category = null): string
    {
        $filename = Str::uuid().'.svg';
        $relative = '/book-thumbnails/'.$filename;
        $absolute = $directory.DIRECTORY_SEPARATOR.$filename;

        $safeTitle = htmlspecialchars(Str::limit($title, 75), ENT_QUOTES);
        $safeCategory = htmlspecialchars(Str::upper($category ?: 'University Library'), ENT_QUOTES);

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="320" height="460" viewBox="0 0 320 460">
  <defs>
    <linearGradient id="bg" x1="0" x2="1" y1="0" y2="1">
      <stop offset="0%" stop-color="#1e3a8a"/>
      <stop offset="100%" stop-color="#2563eb"/>
    </linearGradient>
  </defs>
  <rect width="320" height="460" fill="url(#bg)"/>
  <rect x="20" y="20" width="280" height="420" rx="14" fill="#ffffff" fill-opacity="0.10"/>
  <text x="34" y="70" fill="#dbeafe" font-size="15" font-family="Segoe UI, Arial, sans-serif">{$safeCategory}</text>
  <text x="34" y="135" fill="#ffffff" font-size="26" font-weight="700" font-family="Segoe UI, Arial, sans-serif">
    <tspan x="34" dy="0">{$safeTitle}</tspan>
  </text>
  <text x="34" y="410" fill="#bfdbfe" font-size="14" font-family="Segoe UI, Arial, sans-serif">University Community Library</text>
</svg>
SVG;

        file_put_contents($absolute, $svg);

        return $relative;
    }
}

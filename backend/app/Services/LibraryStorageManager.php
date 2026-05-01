<?php

namespace App\Services;

use App\Models\LibraryFile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LibraryStorageManager
{
    public function provider(): string
    {
        return (string) config('library.storage_provider', 'local');
    }

    /**
     * @return array{provider:string,path:string,external_id:?string,size:int}
     */
    public function storeUploadedPdf(UploadedFile $file): array
    {
        $provider = $this->provider();

        if ($provider !== 'local') {
            throw new RuntimeException(
                "The selected storage provider [{$provider}] is not enabled yet. ".
                'Keep using local storage until cloud setup is confirmed.'
            );
        }

        $disk = (string) config('library.providers.local.disk', 'local');
        $storedPath = $file->storeAs(
            'library',
            uniqid('pdf_', true).'.'.$file->getClientOriginalExtension(),
            $disk
        );

        if (! $storedPath) {
            throw new RuntimeException('Could not store the uploaded PDF file.');
        }

        return [
            'provider' => $provider,
            'path' => $storedPath,
            'external_id' => null,
            'size' => (int) $file->getSize(),
        ];
    }

    public function downloadResponse(LibraryFile $libraryFile): StreamedResponse
    {
        if ($libraryFile->storage_provider !== 'local') {
            throw new RuntimeException('Cloud download integration is not configured yet.');
        }

        $disk = (string) config('library.providers.local.disk', 'local');
        $downloadName = $libraryFile->title.'.pdf';

        return Storage::disk($disk)->download($libraryFile->storage_path, $downloadName);
    }

    public function deleteFile(LibraryFile $libraryFile): void
    {
        if ($libraryFile->storage_provider !== 'local') {
            return;
        }

        $disk = (string) config('library.providers.local.disk', 'local');

        if (Storage::disk($disk)->exists($libraryFile->storage_path)) {
            Storage::disk($disk)->delete($libraryFile->storage_path);
        }
    }
}

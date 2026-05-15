<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Store an uploaded image and return its public URL.
     * If a $oldPath is provided it will be deleted first.
     */
    public function store(UploadedFile $file, string $folder = 'uploads', ?string $oldPath = null): string
    {
        if ($oldPath) {
            $this->delete($oldPath);
        }

        $name = Str::uuid().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $name, 'public');

        return Storage::disk('public')->url($path);
    }

    public function delete(string $url): void
    {
        // Convert public URL back to storage path
        $base = Storage::disk('public')->url('');
        if (str_starts_with($url, $base)) {
            $path = ltrim(substr($url, strlen($base)), '/');
            Storage::disk('public')->delete($path);
        }
    }
}

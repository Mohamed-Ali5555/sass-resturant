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
    public function store(UploadedFile $file, string $folder = 'menu-items', ?string $oldPath = null): string
    {
        if ($oldPath) {
            $this->delete($oldPath);
        }

        $name = Str::uuid().'.'.$file->getClientOriginalExtension();

        // Ensure target directory exists inside public
        $dir = public_path(trim($folder, '/'));
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $file->move($dir, $name);

        return asset(trim($folder, '/').'/'.$name);
    }

    public function delete(string $url): void
    {
        // Try to resolve a public path from the URL and delete the file
        $path = parse_url($url, PHP_URL_PATH);
        if (! $path) {
            return;
        }

        $full = public_path(ltrim($path, '/'));
        if (file_exists($full)) {
            @unlink($full);
        }
    }
}

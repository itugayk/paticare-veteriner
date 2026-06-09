<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('media_url')) {
    /**
     * Resolve a stored media reference to a usable URL.
     * Accepts full URLs (demo seed data) or storage-relative paths (uploads).
     */
    function media_url(?string $path, ?string $fallback = null): ?string
    {
        if (blank($path)) {
            return $fallback;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}

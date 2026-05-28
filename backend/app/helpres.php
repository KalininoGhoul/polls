<?php

if (!function_exists('fileUrl')) {
    function fileUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }
}

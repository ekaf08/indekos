<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('upload')) {
    function upload($directory, $file, $filename = "")
    {
        $extensi    = $file->getClientOriginalExtension();
        $filename   = "{$filename}_" . date('Ymd') . ".{$extensi}";
        Storage::disk('public')->putFileAs("/$directory", $file, $filename);

        return "/$directory/$filename";
    }
}

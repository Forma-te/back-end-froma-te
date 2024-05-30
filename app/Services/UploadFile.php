<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadFile
{
    public function store(UploadedFile $file, string $path): string
    {
        return $file->store($path, 's3');
    }

    public function storeAs(UploadedFile $file, string $path, string $customName): string
    {
        return $file->storeAs($path, $customName, 's3');
    }

    public function removeFile(string $filePath): bool
    {
        if (Storage::disk('s3')->exists($filePath)) {
            return Storage::disk('s3')->delete($filePath);
        }

        return false;
    }
}

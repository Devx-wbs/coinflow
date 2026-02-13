<?php

namespace App\Services;

use App\Models\Storage;
use Illuminate\Support\Facades\Storage as FileStorage;

class StorageService
{
    public function upload($file, $model, $folder = 'uploads')
    {
        // Store file in storage/app/public/{folder}
        $path = $file->store($folder, 'public');

        return Storage::create([
            'file_name'  => $file->getClientOriginalName(),
            'file_path'  => $path,
            'file_type'  => $this->detectType($file->getMimeType()),
            'mime_type'  => $file->getMimeType(),
            'file_size'  => $file->getSize(),
            'model_id'   => $model->id,
            'model_type' => get_class($model),
        ]);
    }

    public function delete($storage)
    {
        if ($storage && FileStorage::disk('public')->exists($storage->file_path)) {
            FileStorage::disk('public')->delete($storage->file_path);
        }

        $storage->delete();
    }

    private function detectType($mime)
    {
        if (str_contains($mime, 'image')) return 'image';
        if (str_contains($mime, 'pdf')) return 'pdf';
        if (str_contains($mime, 'word')) return 'doc';
        if (str_contains($mime, 'excel')) return 'excel';
        if (str_contains($mime, 'zip')) return 'zip';

        return 'other';
    }
}

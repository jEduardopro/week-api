<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait DocumentTrait
{
    public function attach($model, $file, $disk = "documents")
    {
        $originaName = $file->getClientOriginalName();
        $filename = $this->buildCustomName($file);
        $model->documents()->create([
            "name" => $filename,
            "original_name" => $originaName
        ]);
        $this->saveFile($filename, $file, $disk);
        return $model;
    }

    private function buildCustomName($file)
    {
        // $path = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        return 'WK' . time() . '.' . $file->getClientOriginalExtension();
    }

    public function saveFile($filename, $file, $disk)
    {
        Storage::disk($disk)->put($filename, File::get($file));
    }

    public function detach($model, $disk = "documents")
    {
        $documents = $model->documents()->get();
        if ($documents->isNotEmpty()) {
            foreach ($documents as $document) {
                $this->deleteDocument($document, $disk);
            }
        }
    }

    public function deleteDocument($document, $disk)
    {
        Storage::disk($disk)->delete($document->name);
        $document->delete();
    }
}

<?php


namespace App\Http\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileUploaderTrait{


    public function uploadFile($file, $pathName): string{

        $path = $file->storePublicly($pathName, 's3');
        Storage::disk('s3')->url($path);

        $file = explode('/', $path);

        $fileName = $file[array_key_last($file)];
        return $fileName;

    }






}

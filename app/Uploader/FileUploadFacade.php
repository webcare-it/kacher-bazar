<?php

namespace App\Uploader;

use Illuminate\Support\Facades\Facade;

class FileUploadFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'FileUpload';
    }
}

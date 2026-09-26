<?php

namespace App\Uploader;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class FileUpload
{
    use CropTrait, DeleteTrait;

    protected $filename;
    protected $file_obj;
    protected $disk;
    protected $path;
    protected $quality = 60;

    public function upload($disk, $file_obj, $parameters = [])
    {
        $this->file_obj = $file_obj;

        $this->disk = $disk;

        $this->filename = Str::random(25).'.'.$this->file_obj->getClientOriginalExtension();
        Storage::disk($this->disk)->put($this->filename, File::get($this->file_obj));

        $this->executeBulkFunction($parameters, 'crop');
        return $this->filename;
    }

    public function remove($disk, $filename, $parameters = [])
    {
        $this->filename = $filename;

        $this->disk = $disk;

        Storage::disk($this->disk)->delete($this->filename);
        $this->executeBulkFunction($parameters, 'delete');
    }

    private function executeBulkFunction($parameters, $prefix)
    {
        if(count($parameters) > 0) {
            $this->path = Config::get('filesystems.disks.'.$this->disk.'.root');
            foreach($parameters as $parameter) {
                $function = ucwords($parameter);
                $this->{$prefix.str_replace(' ','',$function)}();
            }
        }
    }
}

<?php

namespace App\Uploader;
use Intervention\Image\Facades\Image;

trait CropTrait
{
    public function cropDetails()
    {
        Image::make($this->file_obj)->fit(540, 500)->save($this->path. '/540x500-'.$this->filename, $this->quality );
    }

    public function cropCarousel()
    {
        Image::make($this->file_obj)->fit(240, 240)->save($this->path. '/240x240-'.$this->filename, $this->quality );
    }

    public function cropClientLogo()
    {
        Image::make($this->file_obj)->fit(250, 120)->save($this->path. '/250x120-'.$this->filename, $this->quality );
    }

    public function cropSmallSlider()
    {
        Image::make($this->file_obj)->fit(130, 76)->save($this->path. '/130x76-'.$this->filename, $this->quality );
    }

    public function cropCartImage()
    {
        Image::make($this->file_obj)->fit(40, 40)->save($this->path. '/40x40-'.$this->filename, $this->quality );
    }
}

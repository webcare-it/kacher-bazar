<?php

namespace App\Uploader;

use Illuminate\Support\Facades\Storage;

trait DeleteTrait
{
    public function deleteDetails()
    {
        Storage::disk($this->disk)->delete('540x500-'.$this->filename);
    }

    public function deleteCarousel()
    {
        Storage::disk($this->disk)->delete('240x200-'.$this->filename);
    }

    public function deleteClientLogo()
    {
        Storage::disk($this->disk)->delete('250x120-'.$this->filename);
    }

    public function deleteSmallSlider()
    {
        Storage::disk($this->disk)->delete('130x76-'.$this->filename);
    }

    public function deleteCartImage()
    {
        Storage::disk($this->disk)->delete('40x40-'.$this->filename);
    }
}

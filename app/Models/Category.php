<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillabe = ['name', 'slug', 'image', 'status', 'banner'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'cat_id');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id', 'id');
    }
}

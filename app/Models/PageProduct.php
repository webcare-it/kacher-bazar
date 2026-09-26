<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageProduct extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'sub_cat_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_page_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_page_id', 'id');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class,  'product_page_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_page_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'cat_id',
        'sub_cat_id',
        'brand_id',
        'name',
        'slug',
        'qty',
        'reguler_price',
        'buy_price',
        'discount_price',
        'sku',
        'stock',
        'short_description',
        'long_description',
        'vat_tax',
        'image',
        'gallery_image',
        'color',
        'size',
        'status',
        'product_type',
        'product_address',
        'shipping_to',
        'inside_dhaka',
        'outside_dhaka',
        'delivery_time',
        'seo_title',
        'seo_description',
        'seo_keyword',
    ];

    //===================================== Relationship ======================================//

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
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function pageProductImages()
    {
        return $this->hasMany(ProductImage::class, 'product_page_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'vendor_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function colors()
    {
        return $this->hasMany(ProductColor::class, 'product_id', 'id');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id', 'id');
    }

    public function pageColors()
    {
        return $this->hasMany(ProductColor::class, 'product_page_id', 'id');
    }

    public function pageSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_page_id', 'id');
    }

    public function comboProducts()
    {
        return $this->hasMany(RelatedProduct::class);
    }
    
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }
}

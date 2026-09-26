<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'cat_id',
        'sub_cat_id',
        'name',
        'slug',
        'image',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'sub_cat_id', 'id');
    }
}

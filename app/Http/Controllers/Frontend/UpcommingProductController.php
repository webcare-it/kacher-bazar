<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class UpcommingProductController extends Controller
{
    public function upcommingProducts()
    {
        $upcommingProducts = Product::with('reviews')->where('product_type', 'upcomming')->get();
        return $upcommingProducts;
    }
}

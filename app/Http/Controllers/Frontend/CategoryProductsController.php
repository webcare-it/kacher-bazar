<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryProductsController extends Controller
{
    public function products($id)
    {
        $products = Product::with('reviews')->where('cat_id', $id)->get();
        return response()->json($products, 200);
    }

    public function subcategory_products($id)
    {
        $products = Product::with('reviews')->where('sub_cat_id', $id)->get();
        return response()->json($products, 200);
    }
}

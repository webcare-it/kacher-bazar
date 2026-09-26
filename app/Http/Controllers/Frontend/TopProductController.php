<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class TopProductController extends Controller
{
    public function index()
    {
        return view('frontend.top.products');
    }

    public function products()
    {
        $products = Product::with('reviews')->where('product_type', 'top')->where('status', 1)->get();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }

    public function list()
    {
        $products = Product::with('reviews')->where('product_type', 'top')->where('status', 1)->get();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }
}

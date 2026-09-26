<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HotProductController extends Controller
{
    public function index()
    {
        $products = Product::with('reviews')->where('product_type', 'hot')->orderBy('created_at', 'desc')->where('status', 1)->paginate(12);
        return view('frontend.v-2.product.hot-products', compact('products'));
    }

    public function products()
    {
        $products = Product::with('reviews')->where('product_type', 'hot')->orderBy('created_at', 'desc')->where('status', 1)->get();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }
    public function list()
    {
        $products = Product::with('reviews')->where('product_type', 'hot')->orderBy('created_at', 'desc')->where('status', 1)->get();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }
}

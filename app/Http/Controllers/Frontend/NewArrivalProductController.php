<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class NewArrivalProductController extends Controller
{
    public function index()
    {
        $products = Product::with('reviews')->where('product_type', 'new')->where('status', 1)->orderBy('created_at', 'desc')->paginate(12);
        return view('frontend.v-2.product.new-arrival-products', compact('products'));
    }

    public function products()
    {
        $products = Product::with('reviews')->where('product_type', 'new')->where('status', 1)->get();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }
    public function list()
    {
        $products = Product::with('reviews')->where('product_type', 'new')->where('status', 1)->get();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }
}

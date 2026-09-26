<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Order;
use App\Models\PageProduct;
use App\Models\Product;
use App\Models\ProductReturnProcess;
use App\Models\RelatedProduct;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Models\User;
use App\Repository\Interface\BrandInterface;
use App\Repository\Interface\CategoryInterface;
use App\Repository\Interface\SubcategoryInterface;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use Exception;

class FrontendController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories', 'products')->get();
        $blogs = Blog::take(5)->get();
        $sliders = Setting::all();
        $topBanners = Banner::orderBy('created_at', 'desc')->where('type', 'top')->get();
        $bottomBanner = Banner::where('type', 'footer')->first();
        $hot_products = Product::with('reviews')->where('product_type', 'hot')->where('status', 1)->orderBy('created_at', 'desc')->get();
        $new_products = Product::with('reviews')->where('product_type', 'new')->where('status', 1)->orderBy('created_at', 'desc')->get();
        $regular_products = Product::with('reviews')->where('product_type', 'feature')->where('status', 1)->orderBy('created_at', 'desc')->get();
        $discount_products = Product::with('reviews')->where('product_type', 'discount')->where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('frontend.v-2.home.index', compact('categories', 'blogs', 'sliders', 'bottomBanner',
         'topBanners', 'hot_products', 'new_products', 'regular_products', 'discount_products'));
    }

    public function categories()
    {
        $categories = Category::where('status', 1)->get();
        return response()->json([
            'status' => 200,
            'categories' => $categories
        ]);
    }
    public function subcategories()
    {
        $subcategories = Subcategory::orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 200,
            'subcategories' => $subcategories
        ]);
    }
    public function brands()
    {
        $brands = Brand::orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 200,
            'brands' => $brands
        ]);
    }

    public function productDetails($slug)
    {
        $details = Product::with('category', 'colors', 'sizes', 'pageColors', 'pageSizes', 'reviews')->where('slug', $slug)->first();

        if (!$details) {
            abort(404);
        }

        // Load the correct product images based on product type
        if ($details->is_page_product == 1) {
            // For page products, load images using product_page_id
            $details->load('pageProductImages');
        } else {
            // For regular products, load images using product_id
            $details->load('productImages');
        }

        $related = Product::with('reviews', 'category')->where('status', 1)->where('cat_id', '=', $details->category ? $details->category->id: '')
            ->where('id', '!=', $details->id)
            ->get();

        return view('frontend.v-2.product.details', compact('details', 'related'));
    }

    public function variableProductDetails ($slug)
    {
        $details = Product::with('category','productImages', 'colors', 'sizes', 'reviews')->where('slug', $slug)->first();

        $related = Product::with('reviews', 'category')->where('status', 1)->where('cat_id', '=', $details->category ? $details->category->id: '')
            ->where('id', '!=', $details->id)
            ->get();

        return view('frontend.v-2.product.variable-product-details', compact('details', 'related'));
    }

    public function pageProductDetails ($slug)
    {
        $details = PageProduct::with('category','productImages', 'colors', 'sizes', 'reviews')->where('slug', $slug)->first();

        $related = PageProduct::with('reviews', 'category')->where('status', 1)->where('cat_id', '=', $details->category ? $details->category->id: '')
            ->where('id', '!=', $details->id)
            ->get();

        return view('frontend.v-2.product.details', compact('details', 'related'));
    }

    public function getRelatedProducts()
    {

    }

    public function pageProducts($type)
    {
        $pageProducts = Product::where('page_name', $type)->where('status', 1)->get();
        $pageName = Product::where('page_name', $type)->first();
        return view('frontend.v-2.product.page-products', compact('pageProducts', 'pageName'));
    }

    public function getPageProducts($type)
    {
        //dd($type);
        $pageProducts = PageProduct::where('type', $type)->get();
        return response()->json($pageProducts);
    }

    //======= Bolgs =======//
    public function blogs(){
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        return view('frontend.v-2.blog.blogs', compact('blogs'));
    }

    // public function blogDetails($id, $slug)
    // {
    //     return $blogDetails = Blog::where('id', $id)->first();
    //     return view('frontend.blog.blog-details');
    // }

    public function blogDetails($id)
    {
        $blogDetails = Blog::where('id', $id)->first();
        return view('frontend.v-2.blog.blog-details', compact('blogDetails'));
    }

    //======== Contact Us ===========//
    public function contactUs(){
        return view('frontend.v-2.contact-us.contact-us');
    }

    public function contact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|string|max:15|min:11',
            'message' => 'required|string',
        ]);

        try {
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->phone = $request->phone;
            $contact->message = $request->message;
            $contact->save();
            return redirect()->back()->withSuccess('Thank you for contacting us. as soon as possible we will feedback you, Stay connect with us.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to send message: ' . $e->getMessage());
        }
    }

    //========= setting ==========//
    public function privacyPolicy(){
        return view('frontend.v-2.settings.privacy-policy');
    }
    public function paymentPolicy(){
        return view('frontend.v-2.settings.payment-policy');
    }
    public function shippingPolicy(){
        return view('frontend.v-2.settings.shipping-policy');
    }
    public function returnPolicy(){
        return view('frontend.v-2.settings.return-policy');
    }
    public function refundPolicy(){
        return view('frontend.v-2.settings.refund-policy');
    }
    public function aboutUs(){
        return view('frontend.v-2.settings.about-us');
    }
    public function termConditions(){
        return view('frontend.v-2.settings.terms-condition');
    }
    public function career(){
        return view('frontend.v-2.settings.career');
    }

    public function productFiltering(Request $request)
    {
        $filterProducts = Product::with('category', 'subcategory', 'brand', 'productImages', 'reviews')
        ->where(function($cat) use ($request){
            if($request->category_ids){
                $cat->whereIn('cat_id', $request->category_ids);
            }
        })->orWhere(function($subcat) use ($request){
            if($request->subcategory_ids){
                $subcat->whereIn('sub_cat_id', $request->subcategory_ids);
            }
        })->orWhere(function($brand) use ($request){
            if($request->brand_ids){
                $brand->whereIn('brand_id', $request->brand_ids);
            }
        })->get();
        return $filterProducts;
    }

    public function getAllCategory()
    {
        $categories = Category::latest()->get();
        return $categories;
    }

    public function categoryProducts($slug)
    {
        $categoryProducts = Category::where('slug', $slug) ->with(['products' => function ($query) {
            $query->where('status', 1);
        }])->first();
        return view('frontend.v-2.product.category-products', compact('categoryProducts'));
    }

    public function shops(Request $request)
    {
        $categories = Category::with('products')->get();
        $subcategories = Subcategory::all();
        if(isset($request->category)){
            $products = Product::where('status', 1)->whereIn('cat_id', $request->category)->get();
            return view('frontend.v-2.product.shop-products', compact('categories', 'subcategories', 'products'));
        }
        if(isset($request->subcategory)){
            $products = Product::where('status', 1)->whereIn('sub_cat_id', $request->subcategory)->get();
            return view('frontend.v-2.product.shop-products', compact('categories', 'subcategories', 'products'));
        }

        $products = Product::where('status', 1)->get();
        return view('frontend.v-2.product.shop-products', compact('categories', 'subcategories', 'products'));
    }

    public function subcategoryProducts($slug)
    {
        $subcategoryProducts = Subcategory::where('slug', $slug)->with(['products' => function ($query){
            $query->where('status', 1);
        }])->first();
        return view('frontend.v-2.product.subcategory-products', compact('subcategoryProducts'));
    }

    public function allProducts()
    {
        $products = Product::all();
        return $products;
    }

    public function shopProducts()
    {
        $shopProducts = Product::latest()->get();
        return $shopProducts;
    }

    public function searchData(Request $request)
    {
        $search_data = Product::with('reviews')->where('name', 'LIKE','%'.$request->search.'%')->take(10)->get();
        return response()->json($search_data, 200);
    }


    //===================== Order tracking ===========================//

    public function checkProductStatusForm()
    {
        $categories = Category::with('subcategories')->get();
        $orderTrack = Order::where('orderId', request()->orderId)->first();
        return view('frontend.orderTracking.tracking', compact('categories', 'orderTrack'));
    }


    //================= Social login =======================//

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function loginWithFacebook()
    {
        try {

            $user = Socialite::driver('facebook')->user();

            $finduser = User::where('social_id', $user->id)->first();

            if($finduser){

                Auth::guard('web')->login($finduser);

                return redirect('/checkout');

            }else{
                $newUser = User::create([
                    'social_id'  => $user->id,
                    'first_name' => $user->getName(),
                    'last_name'  => $user->getName(),
                    'email'      => $user->getEmail(),
                    'avatar'     => $user->getAvatar(),
                    'password'   => bcrypt(12345678)
                ]);

                Auth::guard('web')->login($newUser);

                return redirect()->intended('/checkout');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function sitemap()
    {
        $categories = Category::all();
        $products = Product::all();
        $blogs = Blog::all();

        return response()->view('sitemap', [
            'categories' => $categories,
            'products' => $products,
            'blogs' => $blogs,
        ])->header('Content-Type', 'text/xml');
    }

    public function productReturnProcess(){
        return view('frontend.v-2.product.return-process');
    }

    public function productReturnProcessStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'order_id' => 'required|string|max:191',
            'product_id' => 'required|integer',
            'issues' => 'required|string',
            'images' => 'required|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
        ]);

        try {
            $productImage = time() .'.'. $request->images->extension();
            $request->images->move('product', $productImage);

           $customerReturnProduct = ProductReturnProcess::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'order_id' => $request->order_id,
                'product_id' => $request->product_id,
                'issues' => $request->issues,
                'images' => $productImage,
            ]);
            return response()->json($customerReturnProduct, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to submit return request: ' . $e->getMessage()], 500);
        }
    }

    public function showSearchProduct (Request $request)
    {
        $searchValue = $request->search;
        $products = Product::where('name', 'like', '%' . $searchValue . '%')->where('status', 1)->get();
        return view('frontend.v-2.product.search-products', compact('products', 'searchValue'));
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\VendorRequest;
use App\Mail\SupplierForgotMail;
use App\Mail\VendorRegistrationEmail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Supplier;
use App\Models\User;
use App\Repository\Interface\ProductInterface;
use Exception;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class SupplierController extends Controller
{

    protected $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function vendorDeshboard()
    {
        if(auth('supplier')->check()){
            $vendorId = auth('supplier')->user()->id;
            return view('frontend.supplier.dashboard', compact('vendorId'));
        }else{
            return redirect('vendor/login/form')->with('error', 'Unauthenticated user');
        }

    }
    public function profileSetting()
    {
        if(auth('supplier')->check()){
            $vendorId = auth('supplier')->user()->id;
            return view('frontend.supplier.profile-setting', compact('vendorId'));
        }else{
            return redirect('vendor/login/form')->with('error', 'Unauthenticated user');
        }

    }

    public function vendorProductUploadForm()
    {
        $data = [
            'categories'=> Category::orderBy('created_at', 'desc')->get(),
            'brands'=> Brand::orderBy('created_at', 'desc')->get()
        ];
        return view('frontend.supplier.product.create', compact('data'));
    }

    public function register()
    {
        return view('frontend.supplier.register');
    }
    public function loginForm()
    {
        return view('frontend.supplier.login');
    }

    public function store(VendorRequest $request)
    {
        try{
            if($request->file('logo')){
                $avatar = time().'.'. $request->logo->extension();
                $request->logo->move(public_path('avatar'), $avatar);
            }
            $supplier = new Supplier();
            $supplier->first_name = $request->first_name;
            $supplier->last_name = $request->last_name;
            $supplier->logo = $avatar;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->shop_name = $request->shop_name;
            $supplier->address = $request->address;
            $supplier->password = bcrypt($request->password);
            $supplier->save();
            if($supplier->save()){
                Mail::to($supplier->email)->send(new VendorRegistrationEmail($supplier));
            }

            return redirect()->back()->with('success', 'Your registration has been submitted. Please check your email and verify your given email.');
        }catch(Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function vendorLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        $supplierEmail = Supplier::where('email', $request->email)->first();

        if($supplierEmail == null){
            return redirect()->back()->with('error', 'Incorrect email.');
        }

        if($supplierEmail->is_approved == 0){
            return redirect()->back()->with('error', 'Your account still not verified. Please contact admin and verify your account.');
        }

        if (Auth::guard('supplier')->attempt(['email' => $request->email, 'password' => $request->password])) {

            return redirect()->intended('/supplier/dashboard')->with('success', 'You are logddin');
        }
        return redirect()->back()->with('error', 'Something is wrong please try again.');
    }

    public function categoryWiseSubcategory($id)
    {
        $subcategories = Subcategory::where('cat_id', $id)->get();
        return response()->json([
            'subcategories' => $subcategories
        ]);
    }

    public function vendorProductUpload(ProductRequest $request)
    {
        try{
            $data = $request->only(
                [
                    'name',
                    'cat_id',
                    'sub_cat_id',
                    'slug',
                    'brand_id',
                    'vendor_id',
                    'qty',
                    'regular_price',
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
                    'product_type',
                    'product_address',
                    'shipping_to',
                    'inside_dhaka',
                    'outside_dhaka',
                    'delivery_time',
                    'seo_title',
                    'seo_description',
                    'seo_keyword',
                ]
            );
                $this->product->store($data);
                return redirect()->route('vendor.deshboard')->with('success', 'Product has been successfully created.');
        }catch(Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function products($vendorId)
    {
        $products = Product::with('category', 'supplier', 'reviews')->where('vendor_id', $vendorId)->get();
        return response()->json([
            'products' => $products
        ]);
    }

    public function productsEdit($id, $slug)
    {
        $data = [
            'categories'=> Category::orderBy('created_at', 'desc')->get(),
            'brands'=> Brand::orderBy('created_at', 'desc')->get(),
            'product' => $this->product->edit($id),
            'subcategories' => Subcategory::orderBy('created_at', 'desc')->get()
        ];
        return view('frontend.supplier.product.edit', compact('data'));
    }

    public function productsUpdate(ProductUpdateRequest $request, $id)
    {
        $data = $request->only(
            [
                'name',
                'cat_id',
                'sub_cat_id',
                'slug',
                'brand_id',
                'vendor_id',
                'qty',
                'regular_price',
                'buy_price',
                'delivery_charge',
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
                'product_type',
                'product_address',
                'shipping_to',
                'inside_dhaka',
                'outside_dhaka',
                'delivery_time',
                'seo_title',
                'seo_description',
                'seo_keyword',
            ]
        );
        $this->product->update($id, $data);
        return redirect()->route('vendor.deshboard')->with('success', 'Product has been successfully updated.');
    }

    public function productsDelete($id)
    {
        $this->product->delete($id);
        return response()->json(['success' => 'Product has been deleted.']);
    }

    public function vendorOrderProduct()
    {
        $orders = OrderDetails::with('product', 'order')->orderBy('created_at', 'desc')
                                       ->where('vendor_id', auth('supplier')->user()->id)->get();
        return view('frontend.supplier.order', compact('orders'));
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

                return redirect('/');

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

                return redirect()->intended('customer/dashboard');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function loginWithGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

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

                return redirect('/checkout');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    //=====================  Supplier Forgot password =====================//

    public function passwordForgotForm()
    {
        return view('frontend.supplier.forgot');
    }

    public function passwordForgot(Request $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        $email = Supplier::where('email', $request->email)->first();
        if($email){
            Mail::to($request->email)->send(new SupplierForgotMail($email));
            return redirect()->back()->withSuccess('Your forgot password link send your email. Please check and set new password.');
        }else{
            return redirect()->back()->withSuccess('Sorry your email did not registered our record.');
        }
    }

    public function passwordResetForm($email)
    {
        return view('frontend.supplier.password-reset-form', compact('email'));
    }

    public function newPasswordUpdate(Request $request, $email)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:8|max:10',
        ]);

        $passwordUpdate = Supplier::where('email', $email)->first();

        $passwordUpdate->password = bcrypt($request->password);
        $passwordUpdate->save();
        return redirect()->route('customer.login.form')->withSuccess('Your password has been updated.');
    }


    //======================= Forgot password =========================//

    public function vendorForgotPasswordForm()
    {
        return view('frontend.supplier.forgot');
    }

    public function vendorForgotPassword(Request $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        $email = Supplier::where('email', $request->email)->first();
        if($email){
            Mail::to($request->email)->send(new SupplierForgotMail($email));
            return redirect()->back()->withSuccess('Your forgot password link send your email. Please check and set new password.');
        }else{
            return redirect()->back()->withSuccess('Sorry your email did not registered our record.');
        }
    }

    public function vendorPasswordResetForm($email)
    {
        return view('frontend.supplier.password-reset-form', compact('email'));
    }

    public function vendorNewPasswordSet(Request $request, $email)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:8|max:10',
        ]);

        $passwordUpdate = Supplier::where('email', $email)->first();

        $passwordUpdate->password = bcrypt($request->password);
        $passwordUpdate->save();
        return redirect()->route('vendor.login.form')->withSuccess('Your password has been updated.');
    }
}

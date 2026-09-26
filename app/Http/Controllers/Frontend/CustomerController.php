<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRegisterRequest;
use App\Mail\UserForgotPassword;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    public function registerForm()
    {
        return view('frontend.customer.register');
    }

    public function register(CustomerRegisterRequest $request)
    {
        try{
            // if($request->file('avatar')){
            //     $avatar = time().'.'. $request->avatar->extension();
            //     $request->avatar->move(public_path('avatar'), $avatar);
            // }
            $customer = new User();
            // $customer->first_name = $request->first_name;
            // $customer->last_name = $request->last_name;
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->address = $request->address;
            // $customer->phone = $request->phone;
            $customer->password = bcrypt($request->password);
            // $customer->avatar = url('avatar/'.$avatar);
            $customer->save();
            return redirect('/customer/login-form')->with('success', 'Your registration has been successfully done. You can login now.');
        }catch(Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function loginForm()
    {
        return view('frontend.customer.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {

            // return redirect()->intended('/checkout');
            return redirect()->intended('/');
        }
        return redirect()->back()->with('error', 'Email or password dose not match. Please try again.');
    }

    public function dashboard()
    {
        if(auth('web')->check()){
            $orderProducts = Order::with('user', 'orderDetails')->where('user_id', auth('web')->user()->id)->get();
            return view('frontend.customer.dashboard', compact('orderProducts'));
        }else{
            return redirect()->intended('/customer/login-form');
        }


    }

    public function userProfile(){
        $customer = User::find(auth()->user()->id);
        return view('frontend.customer.profile-setting' , compact('customer'));
    }

    public function userProfileUpadet(Request $request){
        $this->validate($request, [
            'first_name' => 'required|string|max:191',
            'last_name' => 'nullable|string|max:191',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg,webp|max:2048',
        ]);

        try {
            $profileUdate = User::where('id', auth()->user()->id)->first();

            if($request->hasFile('avatar')){
                if($profileUdate->avatar && file_exists('avatar/'.$profileUdate->avatar)){
                    unlink('avatar/'.$profileUdate->avatar);
                }
                $image = $request->file('avatar');
                $fileName = date('YmdHi').'.'.$image->getClientOriginalExtension();
                $image->move('avatar', $fileName);
                $profileUdate->avatar = url('avatar/'.$fileName);
                $profileUdate->save();
            }

            $profileUdate->first_name = $request->first_name;
            $profileUdate->last_name = $request->last_name;
            $profileUdate->phone = $request->phone;
            $profileUdate->save();
            return redirect()->back()->with("success", "Profile has been updated");
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function passwordUpdate(Request $request)
    {
        //dd(auth()->user()->password);
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $hashedPassword = Auth::user()->password;
        //dd($hashedPassword);
        if (\Hash::check($request->old_password , $hashedPassword )) {

            if (!\Hash::check($request->password , $hashedPassword)) {

                $users = User::find(Auth::user()->id);
                $users->password = bcrypt($request->password);
                User::where( 'id' , Auth::user()->id)->update( array( 'password' =>  $users->password));

                session()->flash('success','password updated successfully');
                return redirect()->back();
            }

            else{
                session()->flash('error','new password can not be the old password!');
                return redirect()->back();
            }

        }

        else{
            session()->flash('error','old password doesnt matched ');
            return redirect()->back();
        }

    }

    public function passwordForgotForm()
    {
        return view('frontend.customer.forgot');
    }

    public function passwordForgot(Request $request)
    {
        $this->validate($request, [
            'email' => 'required'
        ]);

        $email = User::where('email', $request->email)->first();
        if($email){
            Mail::to($request->email)->send(new UserForgotPassword($email));
            return redirect()->back()->withSuccess('Your forgot password link send your email. Please check and set new password.');
        }else{
            return redirect()->back()->withSuccess('Sorry your email did not registered our record.');
        }
    }

    public function passwordResetForm($email)
    {
        return view('frontend.customer.password-reset-form', compact('email'));
    }

    public function newPasswordUpdate(Request $request, $email)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:8|max:10',
        ]);

        $passwordUpdate = User::where('email', $email)->first();

        $passwordUpdate->password = bcrypt($request->password);
        $passwordUpdate->save();
        return redirect()->route('customer.login.form')->withSuccess('Your password has been updated.');
    }

}

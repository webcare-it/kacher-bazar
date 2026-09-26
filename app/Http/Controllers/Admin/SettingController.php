<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Banner;
use App\Models\GeneralSetting;
use App\Models\GoogleFacebookCode;
use App\Models\PaymentPolicy;
use App\Models\PrivacyPolicy;
use App\Models\RefundPolicy;
use App\Models\TermsCondition;
use Codeboxr\PathaoCourier\Facade\PathaoCourier;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use File;

class SettingController extends Controller
{
    public function bannerAdd()
    {
        return view('admin.settings.banner-create');
    }

    public function bannerList()
    {
        $banners = Banner::orderBy('created_at', 'desc')->get();
        return view('admin.settings.banner-list', compact('banners'));
    }

    public function bannerStore(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'image' => 'required',
        ]);
        $bannerImage = $request->file('image');
        $imageName = time().'.'.$bannerImage->getClientOriginalExtension();
        $destinationPath = 'setting';
        $imgFile = Image::make($bannerImage->getRealPath());
        $imgFile->save($destinationPath.'/'.$imageName);
        $bannerImage->move($destinationPath, $imageName);

        $addNewBanner = new Banner();
        $addNewBanner->type = $request->type;
        $addNewBanner->image = $imageName;
        $addNewBanner->save();
        return redirect('/banner/list')->with('success', 'Banner has been created.');
    }

    public function bannerEdit($id)
    {
        $banner = Banner::find($id);
        return view('admin.settings.banner-edit', compact('banner'));
    }

    public function bannerUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'type' => 'required',
            'image' => 'required',
        ]);
        $banner = Banner::find($id);
        if ($request->hasFile('image')){
            if ($banner->image && file_exists(public_path('/setting/'.$banner->image))){
                unlink(public_path('/setting/'.$banner->image));
            }

            $update_bannerImage = $request->file('image');
            $update_imageName = time().'.'.$update_bannerImage->getClientOriginalExtension();
            $update_destinationPath = 'setting';
            $update_imgFile = Image::make($update_bannerImage->getRealPath());
            $update_imgFile->save($update_destinationPath.'/'.$update_imageName);
            $update_bannerImage->move($update_destinationPath, $update_imageName);
            $banner->image = $update_imageName;
        }
        $banner->type = $request->type;
        $banner->save();
        return redirect('/banner/list')->with('success', 'Banner has been created.');
    }

    public function bannerDelete($id)
    {
        $banner = Banner::find($id);
        $banner->delete();
        File::delete(public_path('setting/'.$banner->image));
        return redirect()->back()->with('success', 'Banner has been deleted');
    }


    public function privacyPolicy()
    {
        $privacyPolicy = PrivacyPolicy::first();
        return view('admin.settings.privacy-policy', compact('privacyPolicy'));
    }

    public function privacyPolicyStore(Request $request)
    {
        $this->validate($request, [
            'privacy_policy' => 'required|string',
        ]);

        try {
            PrivacyPolicy::updateOrCreate([
                'id' => 1
            ], [
                'privacy_policy' => $request->privacy_policy
            ]);
            $this->setSuccessMessage('Privacy Policy has been updated');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update privacy policy: ' . $e->getMessage());
        }
    }

    public function termsCondition()
    {
        $termsCondition = TermsCondition::first();
        return view('admin.settings.terms-condition', compact('termsCondition'));
    }

    public function termsConditionStore(Request $request)
    {
        $this->validate($request, [
            'terms_condition' => 'required|string',
        ]);

        try {
            TermsCondition::updateOrCreate([
                'id' => 1
            ], [
                'terms_condition' => $request->terms_condition
            ]);
            $this->setSuccessMessage('Terms Condition has been updated');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update terms condition: ' . $e->getMessage());
        }
    }

    public function refundPolicy()
    {
        $refundPolicy = RefundPolicy::first();
        return view('admin.settings.refund-policy', compact('refundPolicy'));
    }

    public function refundPolicyStore(Request $request)
    {
        $this->validate($request, [
            'refund_policy' => 'required|string',
        ]);

        try {
            RefundPolicy::updateOrCreate([
                'id' => 1
            ], [
                'refund_policy' => $request->refund_policy
            ]);
            $this->setSuccessMessage('Refund Policy has been updated');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update refund policy: ' . $e->getMessage());
        }
    }

    public function paymentPolicy()
    {
        $paymentPolicy = PaymentPolicy::first();
        return view('admin.settings.payment-policy', compact('paymentPolicy'));
    }

    public function paymentPolicyStore(Request $request)
    {
        $this->validate($request, [
            'payment_policy' => 'required|string',
        ]);

        try {
            PaymentPolicy::updateOrCreate([
                'id' => 1
            ], [
                'payment_policy' => $request->payment_policy
            ]);
            $this->setSuccessMessage('Payment policy has been updated');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update payment policy: ' . $e->getMessage());
        }
    }

    public function adminAbout()
    {
        $about = About::first();
        return view('admin.settings.about', compact('about'));
    }

    public function adminAboutStore(Request $request)
    {
        $this->validate($request, [
            'about' => 'required|string',
        ]);

        try {
            About::updateOrCreate([
                'id' => 1
            ], [
                'about' => $request->about
            ]);
            $this->setSuccessMessage('About has been updated');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update about: ' . $e->getMessage());
        }
    }

    public function showPathaoCourier(){
        return view('admin.settings.pathao-courier');
    }

    public function pathaoCourierStore(Request $request)
    {
        $this->validate($request, [
            'store_id' => 'required|string',
            'merchant_order_id' => 'required|string',
            'recipient_name' => 'required|string|max:191',
            'recipient_phone' => 'required|string|max:20',
            'recipient_address' => 'required|string',
            'recipient_city' => 'required|integer',
            'recipient_zone' => 'required|integer',
            'delivery_type' => 'required|integer',
            'item_type' => 'required|integer',
            'item_quantity' => 'required|integer|min:1',
            'item_weight' => 'required|numeric|min:0',
            'amount_to_collect' => 'required|numeric|min:0',
            'item_description' => 'required|string',
        ]);

        try {
            PathaoCourier::order()->create([
                "store_id"            => $request->store_id,
                "merchant_order_id"   => $request->merchant_order_id,
                "recipient_name"      => $request->recipient_name,
                "recipient_phone"     => $request->recipient_phone,
                "recipient_address"   => $request->recipient_address,
                "recipient_city"      => $request->recipient_city,
                "recipient_zone"      => $request->recipient_zone,
                "recipient_area"      => $request->recipient_area,
                "delivery_type"       => $request->delivery_type,
                "item_type"           => $request->item_type,
                "special_instruction" => $request->speciali_instruction,
                "item_quantity"       => $request->item_quantity,
                "item_weight"         => $request->item_weight,
                "amount_to_collect"   => $request->amount_to_collect,
                "item_description"    => $request->item_description
            ]);

            return redirect()->back()->with('success', 'Parcel has been created');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create parcel: ' . $e->getMessage());
        }
    }


    public function gtmForm()
    {
        $code = GoogleFacebookCode::find(1);
        return view('admin.settings.gtm', compact('code'));
    }

    public function gtmStore(Request $request)
    {
        $this->validate($request, [
            'gtm_id' => 'required',
        ]);

        GoogleFacebookCode::updateOrCreate([
            'id' => 1
        ],[
            'gtm_id' => $request->gtm_id,
        ]);

        return redirect()->back()->with('success', 'Code has been updtaed');
    }

    public function generalSetting ()
    {
        $general_setting = GeneralSetting::first();
        return view('admin.general_setting.index', compact('general_setting'));
    }

    public function updateGeneralSetting (Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:191',
            'address' => 'required|string',
        ]);

        try {
        $general_setting = GeneralSetting::first();
        if (!$general_setting) {
            return redirect()->back()->with('error', 'General settings not found.');
        }
        if($request->hasFile('logo')){
            if(file_exists(public_path('setting/'.$general_setting->logo))){
                File::delete(public_path('setting/'.$general_setting->logo));
                $name = time() . '.' . $request->logo->getClientOriginalExtension();
                $request->logo->move('setting/', $name);
                $general_setting->logo = $name;
            }
            else{
                $name = time() . '.' . $request->logo->getClientOriginalExtension();
                $request->logo->move('setting/', $name);
                $general_setting->logo = $name;
            }

        }

        $general_setting->phone = $request->phone;
        $general_setting->email = $request->email;
        $general_setting->facebook = $request->facebook;
        $general_setting->instagram = $request->instagram;
        $general_setting->twitter = $request->twitter;
        $general_setting->youtube = $request->youtube;
        $general_setting->address = $request->address;
        $general_setting->droploo_app_key = $request->droploo_app_key;
        $general_setting->droploo_app_secret = $request->droploo_app_secret;
        $general_setting->droploo_username = $request->droploo_username;
        $general_setting->steadfast_api_key = $request->steadfast_api_key;
        $general_setting->steadfast_secret_key = $request->steadfast_secret_key;
        $general_setting->primary_color = $request->primary_color;
        $general_setting->secondary_color = $request->secondary_color;
        $general_setting->accent_color = $request->accent_color;
        $general_setting->category_bg_color = $request->category_bg_color;
        $general_setting->header_bg_color = $request->header_bg_color;
        $general_setting->footer_bg_color = $request->footer_bg_color;

        $general_setting->save();

        return redirect()->back()->withSuccess('Updated Successfully!!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }
}

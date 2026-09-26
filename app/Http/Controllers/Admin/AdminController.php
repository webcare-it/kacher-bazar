<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddPage;
use App\Models\Admin;
use App\Models\Contact;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\RelatedProduct;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class AdminController extends Controller
{
    //========== Supplier information ============//

    public function supplierList()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.supplier.list', compact('suppliers'));
    }

    public function supplierDelete($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();

        return redirect()->back()->with('success', 'Supplier has been successfully deleted.');
    }

    public function supplierActive(Supplier $supplier)
    {
        $supplier->is_approved = 0;
        $products = Product::where('vendor_id', $supplier->id)->get();
        foreach ($products as $item) {
            $item->status = 0;
            $item->save();
        }
        $supplier->save();
        return redirect()->back()->with('success', 'Supplier has been successfully inactive.');
    }

    public function supplierInactive(Supplier $supplier)
    {
        $supplier->is_approved = 1;
        $products = Product::where('vendor_id', $supplier->id)->get();
        foreach ($products as $item) {
            $item->status = 1;
            $item->save();
        }
        $supplier->save();
        return redirect()->back()->with('success', 'Supplier has been successfully active.');
    }

    //========== Customer information ============//

    public function customerList()
    {
        $customers = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.customer.list', compact('customers'));
    }

    public function customerDelete($id)
    {
        $customer = User::find($id);
        $customer->delete();
        return redirect()->back()->with('success', 'Customer has been successfully deleted.');
    }

    public function contacts()
    {
        $sql = Contact::orderBy('created_at', 'desc');
        if(isset(request()->search)){
            $sql->where('name', 'LIKE', '%' . request()->search . '%')
                ->orWhere('name', 'LIKE', '%' . request()->search . '%')
                ->orWhere('email', 'LIKE', '%' . request()->search . '%');
        }

        $contacts = $sql->paginate(20);
        return view('admin.contact.index', compact('contacts'));
    }

    public function contactDelete($id)
    {
        $conatct = Contact::find($id);
        $conatct->delete();
        return redirect()->back()->with('success', 'Contact has been successfully deleted.');
    }

    //================== Website Settings ========================//

    public function sliderList()
    {
        $sliders = Setting::get();
        return view('admin.settings.index', compact('sliders'));
    }

    public function sliderCreate()
    {
        return view('admin.settings.create');
    }

    public function sliderStore(Request $request)
    {
        $this->validate($request, [
            'image' => 'required'
        ]);
        if($request->file('image')){
            $image = $request->image;
            $fileName = time().'.'.$image->getClientOriginalExtension();
            $filePath = 'setting';

            $img = Image::make($image->path());
            $img->resize(2376, 807, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$fileName);
        }

        $newSlider = new Setting();
        $newSlider->image = $fileName;
        $newSlider->save();
        return redirect()->back()->with('success', 'Slider image has been added.');
    }

    public function sliderEdit($id)
    {
        $slider = Setting::find($id);
        return view('admin.settings.edit', compact('slider'));
    }

    public function sliderUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'image' => 'required'
        ]);

        $sliderUpdate = Setting::find($id);
        $oldImage = $sliderUpdate->image;
        $image = $request->image;
        if($request->hasFile('image')){
            if($oldImage && file_exists(public_path('setting/'.$oldImage))){
                unlink(public_path('setting/'.$oldImage));
            }
            $fileName = date('YmdHi').'.'.$image->getClientOriginalExtension();
            $filePath = 'setting';
            $img = Image::make($image->path());
            $img->resize(2376, 807, function ($const) {
                $const->aspectRatio();
            })->save($filePath.'/'.$fileName);
            $sliderUpdate->image = $fileName;
            $sliderUpdate->save();
        }
        return redirect()->back()->with('success', 'Slider image has been updated.');
    }

    public function sliderDelete($id)
    {
        $sliderDelete = Setting::find($id);
        $sliderDelete->delete();
        return redirect()->back()->with('success', 'Slider image has been deleted.');
    }

    public function sizeDelete($id)
    {
        $sizeDelete = ProductSize::find($id);
        $sizeDelete->delete();
        return redirect()->back()->with('success', 'Size has been deleted.');
    }

    public function colorDelete($id)
    {
        $colorDelete = ProductColor::find($id);
        $colorDelete->delete();
        return redirect()->back()->with('success', 'Color has been deleted.');
    }

    public function pageList()
    {
        $page = 'index';
        $pages = AddPage::orderBy('id', 'desc')->get();
        return view('admin.settings.page', compact('page', 'pages'));
    }

    public function pageCreate()
    {
        $page = 'create';
        $pages = '';
        return view('admin.settings.page', compact('page', 'pages'));
    }

    // Cache Clear Method
    public function clearCache()
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            \Artisan::call('view:clear');
            \Artisan::call('optimize:clear');

            return redirect()->back()->with('success', 'All caches cleared successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error clearing cache: ' . $e->getMessage());
        }
    }

    public function pageStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'status' => 'required',
        ]);
        try {
            AddPage::create([
                'name' => $request->name,
                'status' => $request->status,
            ]);
            return redirect()->back()->with('success', 'Page has been created.');
        }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function pageEdit($id)
    {
        $page = 'edit';
        $editPage = AddPage::find($id);
        $pages = '';
        return view('admin.settings.page', compact('page', 'pages', 'editPage'));
    }

    public function pageUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'status' => 'required',
        ]);
        $updatePage = AddPage::find($id);
        try {
            $updatePage->update([
                'name' => $request->name,
                'status' => $request->status,
            ]);
            return redirect()->back()->with('success', 'Page has been updated.');
        }catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function pageDelete($id)
    {
        $deletePage = AddPage::find($id);
        $deletePage->delete();
        return redirect()->back()->with('success', 'Page has been deleted.');
    }

    public function pageActive($id)
    {
        $activePage = AddPage::find($id);
        $activePage->status = 1;
        $activePage->save();
        return redirect()->back()->with('success', 'Page has been activated.');
    }

    public function pageInactive($id)
    {
        $inactivePage = AddPage::find($id);
        $inactivePage->status = 0;
        $inactivePage->save();
        return redirect()->back()->with('success', 'Page has been inactivated.');
    }


    //====================Manual Order=====================

    public function addManualOrder (Request $request)
    {
        if(isset($request->search)){
            $products = Product::with('colors', 'sizes', 'productImages')->where('id', $request->search)->orderBy('created_at', 'desc')->get();
            return view('admin.customer.order-manual', compact('products'));
        }
        $products = Product::with('colors', 'sizes', 'productImages')->orderBy('created_at', 'desc')->get();
        return view('admin.customer.order-manual', compact('products'));
    }

    public function checkoutManualOrder ($product_id)
    {
        $products = Product::with('colors', 'sizes', 'productImages')->where('id', $product_id)->get();
        $comboProducts = RelatedProduct::with('products')->get();

        // Get selected size and color from query parameters
        $selectedSize = request('size', '');
        $selectedColor = request('color', '');
        $selectedPrice = request('price', '');

        return view('admin.customer.checkout-manual', compact('products', 'comboProducts', 'selectedSize', 'selectedColor', 'selectedPrice'));
    }

    public function checkoutManualMultipleOrder (Request $request)
    {
        $selectedProduct = $request->id;
        if($selectedProduct == null){
            return redirect()->back()->with('error', 'Select Minimum One!!');
        }
        $products = Product::whereIn('id', $selectedProduct)->with('colors', 'sizes', 'productImages')->get();
        $comboProducts = RelatedProduct::with('products')->get();

        // Get selected sizes and colors from request
        $selectedSizes = $request->size ?? [];
        $selectedColors = $request->color ?? [];

        return view('admin.customer.checkout-manual', compact('products', 'comboProducts', 'selectedSizes', 'selectedColors'));
    }

    public function expenseList (Request $request)
    {
        if(isset($request->from) && isset($request->to)){
            $expenses = Expense::whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to)->get();
            $totalExpense = $expenses->sum('amount');
            return view('admin.expense.expense-list', compact('expenses', 'totalExpense'));
        }
        else{
            $currentMonth = Carbon::now()->format('m');
            $expenses = Expense::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', $currentMonth)->get();
            $totalExpense = $expenses->sum('amount');
            return view('admin.expense.expense-list', compact('expenses', 'totalExpense'));
        }
    }

    public function showAddxpenseForm ()
    {
        return view('admin.expense.add-expense');
    }

    public function storeExpense (Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        try {
            $expense = new Expense();
            $expense->title = $request->title;
            $expense->amount = $request->amount;
            $expense->description = $request->description;
            $expense->user_id = session('id');
            $expense->save();

            $this->setSuccessMessage('Expense is added successfully!');
            return redirect('/expenses');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to add expense: ' . $e->getMessage());
        }
    }

    public function editExpense ($id)
    {
        $expense = Expense::find($id);
        return view('admin.expense.edit-expense', compact('expense'));
    }

    public function updateExpense (Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string|max:191',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        try {
            $expense = Expense::find($id);
            if (!$expense) {
                return redirect('/expenses')->with('error', 'Expense not found.');
            }
            $expense->title = $request->title;
            $expense->amount = $request->amount;
            $expense->description = $request->description;
            $expense->user_id = session('id');
            $expense->save();

            $this->setSuccessMessage('Expense is updated successfully!');
            return redirect('/expenses');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update expense: ' . $e->getMessage());
        }
    }

    public function paymentList (Request $request)
    {
        $users = Admin::where('name', '!=', 'admin')->get();
        if(isset($request->search)){
            $paymentLists = Order::select('id', 'orderId', 'area', 'delivery_charge_type', 'discount', 'advance', 'price', 'employee_id')
            ->with('admin')
            ->where('orderId', $request->search)
            ->where(function ($query) {
                $query->where('pathao_order_status', 'Delivered')
                ->orWhere(function ($subQuery) {
                    $subQuery->whereIn('courier_name', ['Others', 'Steadfast'])
                        ->where('order_status', 'delivered');
                });
            })
            ->get();

            $sumOfPrice = $paymentLists->sum('price');
            $sumOfDeliveryCharge = $paymentLists->sum('area');
            $sumOfDiscount = $paymentLists->sum('discount');
            $sumOfAdvance = $paymentLists->sum('advance');
            $sumOfGrandTotal = $sumOfPrice+$sumOfAdvance;
            return view('admin.payment.payment-list', compact('paymentLists', 'sumOfPrice', 'sumOfGrandTotal', 'sumOfDeliveryCharge', 'sumOfPrice', 'sumOfDiscount', 'users', 'sumOfAdvance'));
        }
        if(isset($request->user_id) && isset($request->from) && isset($request->to)){
            $paymentLists = Order::select('id', 'orderId', 'area', 'delivery_charge_type', 'discount', 'advance', 'price', 'employee_id')
            ->with('admin')->where('employee_id', $request->user_id)
            ->whereDate('updated_at', '>=', $request->from)
            ->whereDate('updated_at', '<=', $request->to)
            ->where(function ($query) {
                $query->where('pathao_order_status', 'Delivered')
                ->orWhere(function ($subQuery) {
                    $subQuery->whereIn('courier_name', ['Others', 'Steadfast'])
                        ->where('order_status', 'delivered');
                });
            })->get();
            $sumOfPrice = $paymentLists->sum('price');
            $sumOfDeliveryCharge = $paymentLists->sum('area');
            $sumOfDiscount = $paymentLists->sum('discount');
            $sumOfAdvance = $paymentLists->sum('advance');
            $sumOfGrandTotal = $sumOfPrice+$sumOfAdvance;
            return view('admin.payment.payment-list', compact('paymentLists', 'sumOfPrice', 'sumOfGrandTotal', 'sumOfDeliveryCharge', 'sumOfPrice', 'sumOfDiscount', 'users', 'sumOfAdvance'));
        }
        if(isset($request->user_id)){
            $paymentLists = Order::select('id', 'orderId', 'area', 'delivery_charge_type', 'discount', 'advance', 'price', 'employee_id')
            ->with('admin')->where('employee_id', $request->user_id)
            ->where(function ($query) {
                $query->where('pathao_order_status', 'Delivered')
                ->orWhere(function ($subQuery) {
                    $subQuery->whereIn('courier_name', ['Others', 'Steadfast'])
                        ->where('order_status', 'delivered');
                });
            })->get();
            $sumOfPrice = $paymentLists->sum('price');
            $sumOfDeliveryCharge = $paymentLists->sum('area');
            $sumOfDiscount = $paymentLists->sum('discount');
            $sumOfAdvance = $paymentLists->sum('advance');
            $sumOfGrandTotal = $sumOfPrice+$sumOfAdvance;
            return view('admin.payment.payment-list', compact('paymentLists', 'sumOfPrice', 'sumOfGrandTotal', 'sumOfDeliveryCharge', 'sumOfPrice', 'sumOfDiscount', 'users', 'sumOfAdvance'));
        }
        if(isset($request->from) && isset($request->to)){
            $paymentLists = Order::select('id', 'orderId', 'area', 'delivery_charge_type', 'discount', 'advance', 'price', 'employee_id')
            ->with('admin')
            ->whereDate('updated_at', '>=', $request->from)
            ->whereDate('updated_at', '<=', $request->to)
            ->where(function ($query) {
                $query->where('pathao_order_status', 'Delivered')
                ->orWhere(function ($subQuery) {
                    $subQuery->whereIn('courier_name', ['Others', 'Steadfast'])
                        ->where('order_status', 'delivered');
                });
            })->get();
            $sumOfPrice = $paymentLists->sum('price');
            $sumOfDeliveryCharge = $paymentLists->sum('area');
            $sumOfDiscount = $paymentLists->sum('discount');
            $sumOfAdvance = $paymentLists->sum('advance');
            $sumOfGrandTotal = $sumOfPrice+$sumOfAdvance;
            return view('admin.payment.payment-list', compact('paymentLists', 'sumOfPrice', 'sumOfGrandTotal', 'sumOfDeliveryCharge', 'sumOfPrice', 'sumOfDiscount', 'users', 'sumOfAdvance'));
        }
        else{
            $currentMonth = Carbon::now()->format('m');
            $paymentLists = Order::select('id', 'orderId', 'area', 'delivery_charge_type', 'discount', 'advance', 'price', 'employee_id')
            ->with('admin')
            ->whereYear('updated_at', Carbon::now()->year)
            ->whereMonth('updated_at', $currentMonth)
            ->where(function ($query) {
                $query->where('pathao_order_status', 'Delivered')
                ->orWhere(function ($subQuery) {
                    $subQuery->whereIn('courier_name', ['Others', 'Steadfast'])
                        ->where('order_status', 'delivered');
                });
            })->get();
            $sumOfPrice = $paymentLists->sum('price');
            $sumOfDeliveryCharge = $paymentLists->sum('area');
            $sumOfDiscount = $paymentLists->sum('discount');
            $sumOfAdvance = $paymentLists->sum('advance');
            $sumOfGrandTotal = $sumOfPrice+$sumOfAdvance;
            return view('admin.payment.payment-list', compact('paymentLists', 'sumOfPrice', 'sumOfGrandTotal', 'sumOfDeliveryCharge', 'sumOfPrice', 'sumOfDiscount', 'users', 'sumOfAdvance'));
        }

    }

    public function showCredentials ()
    {
        $credential = Admin::first();
        return view ('admin.general_setting.credential', compact('credential'));
    }

    public function updateCredentials (Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:8',
        ]);

        try {
            $credential = Admin::first();
            if (!$credential) {
                return redirect()->back()->with('error', 'Credential record not found.');
            }
            $credential->password = bcrypt($request->password);
            $credential->save();
            $this->setSuccessMessage('Credential is updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update credentials: ' . $e->getMessage());
        }
    }
}

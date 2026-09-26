<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function(){
    Route::get('/login/panel', [\App\Http\Controllers\Auth\AdminController::class, 'showAdminLoginForm'])->name('admin.login.form');
    Route::post('/login', [\App\Http\Controllers\Auth\AdminController::class, 'adminLogin'])->name('admin.login');
    Route::group(['middleware' => 'isAdmin'], function(){
        Route::get('/dashboard', [\App\Http\Controllers\Auth\AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [\App\Http\Controllers\Auth\AdminController::class, 'logout'])->name('admin.logout');
    });
});

//Functionality logic
Route::group(['middleware' => 'isAdmin'], function(){
    Route::resource('/categories', CategoryController::class);
    Route::resource('/subcategories', SubcategoryController::class);
    Route::resource('/brands', BrandController::class);

    //General routing
    Route::get('/category-wise-subcategory/{id}', [\App\Http\Controllers\Admin\SubcategoryController::class, 'categoryWiseSubcategory']);
    //Product routing
    Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/dropshipping-products', [\App\Http\Controllers\Admin\ProductController::class, 'dropShippingProducts'])->name('products.dropshipping');
    Route::get('/admin/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
    Route::get('/admin/dropshipping-products/create', [\App\Http\Controllers\Admin\ProductController::class, 'createDropshippingProduct'])->name('admin.dropshipping-products.create');
    Route::post('/products/store', [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::post('/dropshipping-products/store', [\App\Http\Controllers\Admin\ProductController::class, 'storeDropshippingProduct'])->name('dropshipping-products.store');
    Route::get('/products/edit/{id}/{slug}', [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products/update/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::get('/products/active/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'active'])->name('products.active');
    Route::get('/products/inactive/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'inactive'])->name('products.inactive');
    Route::get('/products/delete/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'delete'])->name('products.delete');

    //Variable Product Purpose....
    Route::get('/admin/variable-products/create', [\App\Http\Controllers\Admin\ProductController::class, 'createVariableProduct'])->name('admin.variable-products.create');
    Route::post('/variable-products/store', [\App\Http\Controllers\Admin\ProductController::class, 'storeVariableProduct'])->name('variable.products.store');
    Route::get('/variable-products/edit/{id}/{slug}', [\App\Http\Controllers\Admin\ProductController::class, 'editVariableProduct'])->name('variable.products.edit');
    Route::post('/variable-products/update/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'updateVariableProduct'])->name('variable.products.update');
    Route::post('/dropshipping-variable-products/store', [\App\Http\Controllers\Admin\ProductController::class, 'storeDropshippingVariableProduct'])->name('dropshipping-variable-products.store');

    //Page Products Routing
    Route::get('/page/products', [\App\Http\Controllers\Admin\ProductController::class, 'pageProductIndex'])->name('page.products.index');
    Route::get('/admin/page/products/create', [\App\Http\Controllers\Admin\ProductController::class, 'pageProductcreate'])->name('admin.page.products.create');
    Route::get('/page/products/edit/{id}/{slug}', [\App\Http\Controllers\Admin\ProductController::class, 'pageProductEdit'])->name('page.products.edit');
    Route::post('/page/products/update/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'pageProductUpdate'])->name('page.products.update');

    //======================== All orders =========================//
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'orders'])->name('customer.products.order');
    Route::get('/order/view/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'ordersView'])->name('customer.products.order.view');
    Route::get('/dropshipping-order/view/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'dropshippingOrdersView'])->name('customer.products.dropshipping-order.view');
    Route::get('/order/pdf/{orderId}', [\App\Http\Controllers\Admin\OrderController::class, 'ordersPdf'])->name('customer.products.order.pdf');
    Route::get('/pdf', [\App\Http\Controllers\Admin\OrderController::class, 'pdf']);
    Route::post('/process-selected-orders',[\App\Http\Controllers\Admin\OrderController::class, 'processSelectedOrders'])->name('process.selected.orders');
    Route::get('/download/order-csv/{id}',[\App\Http\Controllers\Admin\OrderController::class, 'downloadCSV'])->name('download.orders.csv');

        //Gallery Image...
    Route::get('/gallery-image/delete/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'galleryImageDelete']);
    Route::get('/gallery-image/edit/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'galleryImageEdit']);
    Route::post('/gallery-image/update/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'galleryImageUpdate']);
    
    Route::get('/admin/customer/review', [\App\Http\Controllers\Admin\OrderController::class, 'customerReview']);
    Route::get('/add/customer/review', [\App\Http\Controllers\Admin\OrderController::class, 'customerReviewForm']);
    Route::post('/admin/customer/review/store', [\App\Http\Controllers\Admin\OrderController::class, 'customerReviewStore']);
    Route::get('/admin/customer/review/edit/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'customerReviewEdit']);
    Route::post('/admin/customer/review/update/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'customerReviewUpdate']);
    Route::get('/admin/customer/review/delete/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'customerReviewDelete']);

//    Route::get('pdf', function () {
//        return view('admin.pdf');
//     });

    //======================== Order reports =========================//
    Route::get('/order/report', [\App\Http\Controllers\Admin\ReportController::class, 'ordersReport'])->name('customer.products.order.report');
    Route::get('/order/cancel', [\App\Http\Controllers\Admin\ReportController::class, 'ordersCancel']);
    Route::get('/order/hold', [\App\Http\Controllers\Admin\ReportController::class, 'ordersHold']);
    Route::get('/order/pending', [\App\Http\Controllers\Admin\ReportController::class, 'ordersPending']);
    Route::get('/complete/order', [\App\Http\Controllers\Admin\ReportController::class, 'ordersComplete']);
    Route::get('/order/delivery', [\App\Http\Controllers\Admin\ReportController::class, 'ordersDelivery']);
    Route::get('/all-orders', [\App\Http\Controllers\Admin\ReportController::class, 'allOrders']);
    Route::get('/transferred-orders', [\App\Http\Controllers\Admin\ReportController::class, 'transferredOrders']);
    Route::get('/order/pending-payment', [\App\Http\Controllers\Admin\ReportController::class, 'pendingPaymentOrder']);
    Route::get('/today-manual', [\App\Http\Controllers\Admin\ReportController::class, 'todayManual']);
    Route::get('/today-orders', [\App\Http\Controllers\Admin\ReportController::class, 'todayOrders']);
    Route::get('/today-cancel', [\App\Http\Controllers\Admin\ReportController::class, 'todayCancel']);
    Route::get('/today-hold', [\App\Http\Controllers\Admin\ReportController::class, 'todayHold']);
    Route::get('/today-pending', [\App\Http\Controllers\Admin\ReportController::class, 'todayPending']);
    Route::get('/today-delivered', [\App\Http\Controllers\Admin\ReportController::class, 'todayDelivered']);
    Route::get('/all-manual-orders', [\App\Http\Controllers\Admin\ReportController::class, 'allManual']);
    Route::get('/all-website-orders', [\App\Http\Controllers\Admin\ReportController::class, 'allWebsite']);
    Route::get('/deleted/order', [\App\Http\Controllers\Admin\ReportController::class, 'deletedOrder']);
    Route::get('/order/return/list', [\App\Http\Controllers\Admin\ReportController::class, 'orderReturnList']);
    Route::get('/order/damage/list', [\App\Http\Controllers\Admin\ReportController::class, 'orderDamageList']);
    Route::get('/order/missing/list', [\App\Http\Controllers\Admin\ReportController::class, 'orderMissingList']);
    //======================== Order status =========================//
    // Route::get('/status/cancel/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'cancel']);
    // Route::get('/status/hold/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'hold']);
    // Route::get('/status/hold/form/{orderId}', [\App\Http\Controllers\Admin\ReportController::class, 'showHoldReasonForm']);
    // Route::post('/status/hold', [\App\Http\Controllers\Admin\ReportController::class, 'holdNoteStore']);
    Route::get('/status/complete/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'completeStatus']);
    Route::post('/order/update', [\App\Http\Controllers\Admin\ReportController::class, 'statusUpdate']);

    Route::get('/status/cancel/form/{orderId}', [\App\Http\Controllers\Admin\ReportController::class, 'showCancelReasonForm']);
    Route::post('/status/cancel', [\App\Http\Controllers\Admin\ReportController::class, 'cancel']);
    Route::get('/status/hold/form/{orderId}', [\App\Http\Controllers\Admin\ReportController::class, 'showHoldReasonForm']);
    Route::post('/status/hold', [\App\Http\Controllers\Admin\ReportController::class, 'hold']);

    Route::get('/pending/status/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'pendingStatus']);
    Route::get('/status/pending-payment/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'pendingPayment']);
    Route::post('/user/order/update/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'userOrderUpdate']);
    Route::post('/user/dropshipping-order/transfer/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'userDropshippingOrderTransfer']);
    Route::get('/order/delete/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'orderDetailsDelete']);

    Route::get('/order/return/status/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'orderReturn']);
    Route::get('/order/damage/status/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'orderDamage']);
    Route::get('/order/missing/status/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'orderMissing']);
    Route::get('/order/delivered/status/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'orderDelivered']);
    Route::get('/order/customer-confirm/status/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'orderCustomerConfirm']);
    Route::get('/order/request-return/status/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'orderRequestReturn']);
    Route::get('/order/paid/status/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'orderPaid']);
    Route::get('/status/invoice-checked/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'invoiceChecked']);
    Route::get('/status/invoiced/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'invoiced']);
    Route::get('/status/stock-out/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'stockOut']);
    Route::get('/order/schedule-delivery/status/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'scheduleDelivery']);
    Route::get('/invoice', [\App\Http\Controllers\Admin\ReportController::class, 'invoiceList']);

    //======================== Purchase =========================//
    Route::get('/purchase', [\App\Http\Controllers\Admin\PurchaseController::class, 'purchase']);
    Route::get('/purchase/create', [\App\Http\Controllers\Admin\PurchaseController::class, 'purchaseCreate']);
    Route::post('/purchase/store', [\App\Http\Controllers\Admin\PurchaseController::class, 'purchaseStore']);
    //======================== Purchase =========================//

    //======================== All stocks =========================//
    Route::get('/stocks', [\App\Http\Controllers\Admin\OrderController::class, 'stocks'])->name('products.stock');

    Route::group(['prefix' => 'status'], function(){
        Route::get('/pending/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'pending'])->name('order.pending');
        Route::get('/shipping/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'shipping'])->name('order.shipping');
//        Route::get('/complete/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'complete'])->name('order.complete');
    });

    //========== Customer and Supplier list ===============//
    Route::get('/supplier/list', [\App\Http\Controllers\Admin\AdminController::class, 'supplierList']);
    Route::get('/supplier/active/{supplier}', [\App\Http\Controllers\Admin\AdminController::class, 'supplierActive']);
    Route::get('/supplier/inactive/{supplier}', [\App\Http\Controllers\Admin\AdminController::class, 'supplierInactive']);
    Route::get('/supplier/delete/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'supplierDelete']);
    Route::get('/customer/list', [\App\Http\Controllers\Admin\AdminController::class, 'customerList']);
    Route::get('/customer/delete/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'customerDelete']);
    Route::get('/contacts', [\App\Http\Controllers\Admin\AdminController::class, 'contacts']);
    Route::get('/contact/delete/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'contactDelete']);

    //========== Website settings ===============//
    Route::get('/slider/list', [\App\Http\Controllers\Admin\AdminController::class, 'sliderList']);
    Route::get('/slider/create', [\App\Http\Controllers\Admin\AdminController::class, 'sliderCreate']);
    Route::post('/slider/store', [\App\Http\Controllers\Admin\AdminController::class, 'sliderStore']);
    Route::get('/slider/edit/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'sliderEdit']);
    Route::post('/slider/update/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'sliderUpdate']);
    Route::get('/slider/delete/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'sliderDelete']);

    Route::get('/banner/add', [\App\Http\Controllers\Admin\SettingController::class, 'bannerAdd']);
    Route::get('/banner/list', [\App\Http\Controllers\Admin\SettingController::class, 'bannerList']);
    Route::post('/banner/store', [\App\Http\Controllers\Admin\SettingController::class, 'bannerStore']);
    Route::get('/banner/edit/{id}', [\App\Http\Controllers\Admin\SettingController::class, 'bannerEdit']);
    Route::post('/banner/update/{banner}', [\App\Http\Controllers\Admin\SettingController::class, 'bannerUpdate']);
    Route::get('/banner/delete/{banner}', [\App\Http\Controllers\Admin\SettingController::class, 'bannerDelete']);

    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'generalSetting']);
    Route::post('/settings/update', [\App\Http\Controllers\Admin\SettingController::class, 'updateGeneralSetting']);

    Route::get('/admin/gtm', [\App\Http\Controllers\Admin\SettingController::class, 'gtmForm']);
    Route::post('/admin/gtm/store', [\App\Http\Controllers\Admin\SettingController::class, 'gtmStore'])->name('admin.gtm.store');

    //============== privacy pages ==================//
    Route::get('/admin/privacy/policy', [\App\Http\Controllers\Admin\SettingController::class, 'privacyPolicy']);
    Route::post('/admin/privacy/policy/store', [\App\Http\Controllers\Admin\SettingController::class, 'privacyPolicyStore'])->name('admin.privacy.policy.store');

    Route::get('/admin/terms/condition', [\App\Http\Controllers\Admin\SettingController::class, 'termsCondition']);
    Route::post('/admin/terms/condition/store', [\App\Http\Controllers\Admin\SettingController::class, 'termsConditionStore'])->name('admin.terms.condition.store');

    Route::get('/admin/refund/policy', [\App\Http\Controllers\Admin\SettingController::class, 'refundPolicy']);
    Route::post('/admin/refund/policy/store', [\App\Http\Controllers\Admin\SettingController::class, 'refundPolicyStore'])->name('admin.refund.policy.store');

    Route::get('/admin/payment/policy', [\App\Http\Controllers\Admin\SettingController::class, 'paymentPolicy']);
    Route::post('/admin/payment/policy/store', [\App\Http\Controllers\Admin\SettingController::class, 'paymentPolicyStore'])->name('admin.payment.policy.store');

    Route::get('/admin/about', [\App\Http\Controllers\Admin\SettingController::class, 'adminAbout']);
    Route::post('/admin/about/store', [\App\Http\Controllers\Admin\SettingController::class, 'adminAboutStore'])->name('admin.about.store');

    //============== Blog ==================//
    Route::group(['prefix' => 'blog'], function(){
        Route::get('/list', [\App\Http\Controllers\Admin\BlogController::class, 'index']);
        Route::get('/create', [\App\Http\Controllers\Admin\BlogController::class, 'create']);
        Route::post('/store', [\App\Http\Controllers\Admin\BlogController::class, 'store']);
        Route::get('/edit/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'edit']);
        Route::post('/update/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'update']);
        Route::get('/delete/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'destroy']);

        Route::get('/active/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'active']);
        Route::get('/inactive/{blog}', [\App\Http\Controllers\Admin\BlogController::class, 'inactive']);
    });

    Route::get('/product/size/delete/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'sizeDelete']);
    Route::get('/product/color/delete/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'colorDelete']);

    Route::get('/page/list', [\App\Http\Controllers\Admin\AdminController::class, 'pageList']);
    Route::get('/page/create', [\App\Http\Controllers\Admin\AdminController::class, 'pageCreate']);
    Route::post('/page/store', [\App\Http\Controllers\Admin\AdminController::class, 'pageStore']);
    Route::get('/page/edit/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'pageEdit']);
    Route::post('/page/update/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'pageUpdate']);
    Route::get('/page/delete/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'pageDelete']);
    Route::get('/page/active/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'pageActive']);
    Route::get('/page/inactive/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'pageInactive']);


    //User
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index']);
    Route::get('/add-user', [App\Http\Controllers\Admin\UserController::class, 'addUser']);
    Route::post('/store-user', [App\Http\Controllers\Admin\UserController::class, 'storeUser']);
    Route::get('/activate-user/{id}', [App\Http\Controllers\Admin\UserController::class, 'activateUser']);
    Route::get('/inactivate-user/{id}', [App\Http\Controllers\Admin\UserController::class, 'inActivateUser']);
    Route::get('/edit-user/{id}', [App\Http\Controllers\Admin\UserController::class, 'editUser']);
    Route::post('/update-user/{id}', [App\Http\Controllers\Admin\UserController::class, 'updateUser']);
    Route::get('/delete-user/{id}', [App\Http\Controllers\Admin\UserController::class, 'deleteUser']);
    Route::get('/user/details/{id}', [App\Http\Controllers\Admin\UserController::class, 'detailsUser']);
    Route::get('/user/order-list/{order_type}/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'orderListUser']);
    Route::get('/user/order-list/today/{order_type}/{user_id}', [App\Http\Controllers\Admin\UserController::class, 'orderListTodayUser']);
    Route::get('/user/assign', [App\Http\Controllers\Admin\UserController::class, 'userAssignOrderList']);
    Route::post('/assign-users/for-selected-orders', [App\Http\Controllers\Admin\UserController::class, 'assignUserOrder']);
    //User

    //Manual Order...
    Route::get('order/add-manually', [\App\Http\Controllers\Admin\AdminController::class, 'addManualOrder']);
    Route::get('order/checkout-manually/{product_id}', [\App\Http\Controllers\Admin\AdminController::class, 'checkoutManualOrder']);
    Route::post('order/checkout-manually/multiple', [\App\Http\Controllers\Admin\AdminController::class, 'checkoutManualMultipleOrder']);
    //Manual Order...

    //Pathao API Test...
    Route::get('pathao/city-list', [\App\Http\Controllers\Admin\PathaoCourierController::class, 'cityList']);
    Route::get('pathao/zone-list/{cityId}', [\App\Http\Controllers\Admin\PathaoCourierController::class, 'zoneList']);
    Route::get('pathao/area-list/{zoneId}', [\App\Http\Controllers\Admin\PathaoCourierController::class, 'areaList']);
    Route::get('pathao/create-new-parcel', [\App\Http\Controllers\Admin\PathaoCourierController::class, 'createNewParcel']);
    Route::get('pathao/store-list', [\App\Http\Controllers\Admin\PathaoCourierController::class, 'storeList']);
    //Pathao API Test...

    //Pathao API Implementation...
    Route::get('/get-zones/{cityId}', [\App\Http\Controllers\Admin\OrderController::class, 'zoneList']);
    //Pathao API Implementation...

    //Expenses...
    Route::get('/expenses', [\App\Http\Controllers\Admin\AdminController::class, 'expenseList']);
    Route::get('/add-expense', [\App\Http\Controllers\Admin\AdminController::class, 'showAddxpenseForm']);
    Route::post('/store-expense', [\App\Http\Controllers\Admin\AdminController::class, 'storeExpense']);
    Route::get('/edit-expense/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'editExpense']);
    Route::post('/update-expense/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'updateExpense']);
    //Expenses...

    //Payment Reports...
    Route::get('/payment-reports', [\App\Http\Controllers\Admin\AdminController::class, 'paymentList']);
    //Payment Reports

    //Credentials...
    Route::get('/admin/show/credentials', [\App\Http\Controllers\Admin\AdminController::class, 'showCredentials']);
    Route::post('/admin/update/credentials', [\App\Http\Controllers\Admin\AdminController::class, 'updateCredentials']);

    //Cache Clear...
    Route::get('/admin/cache-clear', [\App\Http\Controllers\Admin\AdminController::class, 'clearCache'])->name('admin.cache.clear');

    //droploo Product API......
    Route::get('/droploo-products', [\App\Http\Controllers\Admin\ProductController::class, 'droplooProductList']);
    Route::get('/add-droploo-product/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'droplooProductAdd']);
});

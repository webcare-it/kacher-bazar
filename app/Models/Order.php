<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'vendor_id', 'product_id', 'qty', 'price', 'orderId', 'phone'];

    //===================================== Relationship ======================================//

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->with('shipping', 'billing', 'payment', 'order');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class)->with('product');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class, 'sub_district_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'employee_id', 'id');
    }

    public function invoiceNumber()
{
    $prefix = strtoupper(str_replace(' ', '', config('app.name'))); // Full app name (no spaces, all uppercase)

    $orderLast = Order::orderBy('id', 'desc')->first();

    if (! $orderLast) {
        return $prefix . '0001';
    }

    $lastInvoice = $orderLast->orderId ?? null;

    if ($lastInvoice) {
        // Extract numeric part from the previous invoice number
        $number = (int) filter_var($lastInvoice, FILTER_SANITIZE_NUMBER_INT);
        return $prefix . sprintf('%04d', $number + 1);
    }

    return $prefix . '0001';
}

    /**
     * Helper function to set value in .env file
     */
    protected function setEnvValue($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $env = file_get_contents($path);

            // If key exists, replace it
            if (preg_match("/^{$key}=.*/m", $env)) {
                $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
            } else {
                // Append the key if it does not exist
                $env .= "\n{$key}={$value}\n";
            }

            file_put_contents($path, $env);
        }
    }

    public function notification()
    {
        return $this->morphOne(Notification::class, 'notifiable');
    }
}

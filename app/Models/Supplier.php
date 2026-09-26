<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Supplier extends Authenticatable
{
    use HasFactory;

    protected $guard = 'supplier';

    /******************** */
    /*** Accessor ***/
    /******************** */

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'shop_name',
        'address',
        'logo',
        'is_approved',
        'remember',
        'social_id',
        'password',
    ];


    //================= Relationship ===================//

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

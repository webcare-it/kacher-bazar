<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country_id',
        'city_id',
        'district_id',
        'shipping_charge',
        'address'
    ];

    /******************** */
    /*** Accessor ***/
    /******************** */

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    //=========== Relationship ============//

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

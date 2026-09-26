<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'payment_type', 'total_pay'];


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

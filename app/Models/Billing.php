<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $guarded = [];

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

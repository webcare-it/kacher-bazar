<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Codeboxr\PathaoCourier\Facade\PathaoCourier;
use Illuminate\Http\Request;

class PathaoCourierController extends Controller
{
    public function storeList ()
    {
        return PathaoCourier::store()->list();
    }
}

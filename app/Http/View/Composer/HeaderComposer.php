<?php

namespace App\Http\View\Composer;

use App\Models\Category;
use Illuminate\View\View;

class HeaderComposer 
{
    public function compose(View $view)
    {
        $view->with('categories', Category::latest()->get());
    }
}
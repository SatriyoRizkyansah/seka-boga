<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;

class CartComposer
{
    public function compose(View $view)
    {
        $cartCount = 0;
        
        if (Auth::check()) {
            $cartCount = Keranjang::where('customer_id', Auth::id())->sum('jumlah');
        }
        
        $view->with('cartCount', $cartCount);
    }
}
<?php

namespace App\Http\Controllers;

use App\Cart\Contracts\CartInterface;
use App\Cart\Exceptions\QuantityNoLongerAvailableException;
use Illuminate\Http\Request;

class CartIndexController extends Controller
{
    public function __invoke(CartInterface $cart)
    {
        try {
            $cart->verifyAvailableQuantities();
        }catch(QuantityNoLongerAvailableException $e){

            session()->flash('notification','Bazı ürünlerdeki talep miktarınız stoğu aşmıştır.');

            $cart->syncAvailableQuantities();
        }

        return view('cart.index');
    }
}

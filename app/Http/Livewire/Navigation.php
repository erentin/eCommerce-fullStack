<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Cart\Contracts\CartInterface;
use Livewire\Component;

class Navigation extends Component
{

    public $searchQuery;

    protected $listeners = [
        'cart.updated' => '$refresh'
    ];

    public function getCartProperty(CartInterface $cart)
    {
        return $cart;
    }

    public function clearSearch()
    {
        $this->searchQuery = '';
    }

    public function render(CartInterface $cart)
    {

        $products = Product::search($this->searchQuery)->get();

        return view('livewire.navigation',[

            'products' => $products,
            'searchQuery' => $this->searchQuery,
        ]);

    }
}

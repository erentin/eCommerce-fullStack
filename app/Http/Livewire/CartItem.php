<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Cart\Contracts\CartInterface;

class CartItem extends Component
{

    public $variation;
    
    public $quantity;

    public function mount()
    {
        $this->quantity = $this->variation->pivot->quantity;
    }

    public function updatedQuantity($quantity)
    {
        app(CartInterface::class)->changeQuantity($this->variation, $quantity);

        $this->emit('cart.updated');

        $this->dispatchBrowserEvent('notification',[
            'body' => "Adet Sayısı Güncellendi"
        ]);
    }

    public function remove(CartInterface $cart)
    {
        $cart->remove($this->variation);

        $this->emit('cart.updated');

        $this->dispatchBrowserEvent('notification',[
            'body' => $this->variation->product->title. ' ' . "Ürünü sepetinizden silindi."
        ]);
    }

    public function render()
    {
        return view('livewire.cart-item');
    }
}

<?php

namespace App\Http\Livewire;

use App\Cart\Contracts\CartInterface;
use App\Models\Order;
use App\Models\ShippingAddress;
use App\Models\ShippingType;
use Cknow\Money\Money;
use Livewire\Component;

class Checkout extends Component
{
    public $shippingTypes;

    public $shippingTypeId;

    public $shippingAddress;

    public $addressSelect = "";

    public $accountForm= [
        'email' => "heysu",
    ];

    public $shippingForm = [
        'address' => 'asfa',
        'city' => 'asfasf',
        'postcode' => 'asfasf'
    ];

    protected $validationAttributes =[
        'accountForm.email' => 'email address',
    ];

    protected $messages = [
        'accountForm.email.unique' => 'Girdiğiniz e-mail adresi bulunmaktadır.',
        'accountForm.email.required' => 'Bu alan boş bırakılamaz!',
        'shippingForm.address.required' => 'Bu alan boş bırakılamaz!',
        'shippingForm.postcode.required' => 'Bu alan boş bırakılamaz!',
        'shippingForm.city.required' => 'Bu alan boş bırakılamaz!',
    ];

    public function mount()
    {
        $this->shippingTypes = ShippingType::orderBy('price','asc')->get();

        $this->shippingTypeId = $this->shippingTypes->first()->id;

        if($user = auth()->user())
        {
            $this->accountForm['email'] = $user->email;
        }
    }

    public function getUserShippingAdressesProperty()
    {
        return auth()->user()?->shippingAdresses;
    }
    
    public function updatedAddressSelect($id)
    {
        if(!$id)
        {
            return;
        }

        $this->shippingForm = $this->UserShippingAdresses->find($id)->only('address','city','postcode');
    }

    public function checkout(CartInterface $cart)
    {
        $this->validate();

        $this->shippingAddress = ShippingAddress::query();

        if(auth()->user())
        {
            $this->shippingAddress = $this->shippingAddress->whereBelongsTo(auth()->user());
        }

        $this->shippingAddress = ShippingAddress::firstOrCreate($this->shippingForm)
            ?->user()
            ->associate(auth()->user())
            ->save();

        $order = Order::make(array_merge($this->accountForm,[
            'subtotal' => $cart->subtotal()
        ]));

        $order->user()->associate(auth()->user());
        
        $order->shippingType()->associate($this->shippingTypeId);
        $order->shippingAddress()->associate($this->shippingAddress);


        $order->save();

        $order->variations()->attach($cart->contents()->mapWithKeys(function ($variation) {
            return [
                $variation->id => [
                    'quantity' => $variation->pivot->quantity
                ]
            ];
        })
        ->toArray()
    );

        $cart->contents()->each(function ($variation) {
            $variation->stocks()->create([
                'amount' => 0 - $variation->pivot->quantity
            ]);
        });

        $cart->removeAll();

        if(!auth()->user())
        {

            return redirect()->route('orders.confirmation',[
                'order' => $order
            ]);
        }

        return redirect()->route('orders');
        
    }

    public function rules()
    {
        return [
            'accountForm.email' => 'required|email|max:255|unique:users,email' . (auth()->user() ? ',' . auth()->user()->id : ''),

            'shippingForm.address' => 'required|max:255',
            'shippingForm.city' => 'required|max:255',
            'shippingForm.postcode' => 'required|max:255',

            'shippingTypeId' => 'required|exists:shipping_types,id'
        ];
    }

    public function getShippingTypeProperty()
    {
        return $this->shippingTypes->find($this->shippingTypeId);
    }

    public function getFormattedTotalProperty(CartInterface $cart)
    {
        return Money::TRY($cart->subtotal() + $this->shippingType->price,true);
    }

    public function render(CartInterface $cart,ShippingType $shippingType)
    {
        return view('livewire.checkout',[
            'cart' => $cart,
        ]);
    }
}

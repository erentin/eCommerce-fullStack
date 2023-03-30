<?php

namespace App\Cart;

use App\Cart\Contracts\CartInterface;
use App\Models\User; 
use App\Models\Cart as ModelsCart;
use Illuminate\Session\SessionManager;

class Cart implements CartInterface
{
    public function __construct(protected SessionManager $session)
    {
        
    }

    public function exists()
    {
        return $this->session->has(config('cart.session.key'));
    }

    public function create(?User $user = null)
    {
        $instance = ModelsCart::make();

        if ($user) {
            $instance->user()->associate($user);
        }

        $instance->save();

        $this->session->put(config('cart.session.key'),$instance->uuid);
    }

    public function instance()
    {
        return ModelsCart::whereUuid()->first();
    }

} 



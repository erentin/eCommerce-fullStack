<form wire:submit.prevent="checkout">
    <div class="overflow-hidden sm:rounded-lg grid grid-cols-6 grid-flow-col gap-4">
        <div class="p-6 bg-white border-b border-gray-200 col-span-3 self-start space-y-6">
            <div class="space-y-3">
                <div class="font-semibold text-lg">Account details</div>
                @guest    
                <div>
                    <label for="email">Email</label>
                    <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" wire:model.defer="accountForm.email"/>
                    @error('accountForm.email')
                    <div class="mt-2 font-semibold text-red-500">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                @endguest
            </div>

            <div class="space-y-3">
                <div class="font-semibold text-lg">Shipping</div>

                <x-select class="w-full" wire:model="addressSelect">
                    <option value="" disabled>{{Auth()->user() ? "Kayıtlı Adresinizi Seçebilirsiniz" : "Adres Seçebilmek için Giriş Yapmalısınız"}}</option>
                    @auth    
                    @foreach ($this->UserShippingAdresses as $address)    
                        <option value="{{$address->id}}">{{$address->formattedAddress($address->id)}}</option>
                    @endforeach
                    @endauth
                </x-select>


                <div class="space-y-3">
                    <div>
                        <label for="address">Address</label>
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" wire:model.defer="shippingForm.address"/>

                        @error('shippingForm.address')
                        <div class="mt-2 font-semibold text-red-500">
                            {{$message}}
                        </div>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label for="city">City</label>
                            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" wire:model.defer="shippingForm.city" />

                            @error('shippingForm.city')
                            <div class="mt-2 font-semibold text-red-500">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="col-span-1">
                            <label for="postcode">Postal code</label>
                            <x-text-input id="postcode" class="block mt-1 w-full" type="text" name="postcode" wire:model.defer="shippingForm.postcode" />

                            @error('shippingForm.postcode')
                            <div class="mt-2 font-semibold text-red-500">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-3">
                <div class="font-semibold text-lg">Delivery</div>
                <div class="space-y-1">
                    <x-select class="w-full" wire:model="shippingTypeId">
                        @foreach ($shippingTypes as $shippingType)    
                        <option value="{{$shippingType->id}}">{{$shippingType->title}} ( {{$shippingType->formattedPrice($shippingType->price)}} )</option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            <div class="space-y-3">
                <div class="font-semibold text-lg">Payment</div>

                <div>
                    Stripe card form
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border-b border-gray-200 col-span-3 self-start space-y-4">
            @foreach ($cart->contents() as $variation)  
            <div>
                <div class="w-16 mr-4">
                    <img src="{{$variation->product->getFirstMediaUrl('default','thumb200x200')}}" class="w-16">
                </div>

                <div class="space-y-2">
                    <div>
                        <div class="font-semibold">
                            {{$variation->formattedPrice($variation->price)}}
                        </div>
                        <div class="space-y-1">
                            <div>{{$variation->product->title}}</div>

                            <div class="flex items-center text-sm">
                                <div class="mr-1 font-semibold">
                                    Quantity: {{$variation->pivot->quantity}}<span class="text-gray-400 mx-1">/</span>
                                </div>
                                
                                @foreach ($variation->ancestorsAndSelf as $ancestor)   
                                {{$ancestor->title}} <span class="text-gray-400 mx-1">/</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
                <div class="border-b py-3 flex items-start">
            </div>

            <div class="space-y-4">
                <div class="space-y-1">
                    <div class="space-y-1 flex items-center justify-between">
                        <div class="font-semibold">Subtotal</div>
                        <h1 class="font-semibold">{{$cart->formattedSubtotal()}}</h1>
                    </div>

                    <div class="space-y-1 flex items-center justify-between">
                        <div class="font-semibold">Shipping ({{$this->shippingType->title}})</div>
                        <h1 class="font-semibold">{{$this->shippingType->formattedPrice()}}</h1>
                    </div>


                    <div class="space-y-1 flex items-center justify-between">
                        <div class="font-semibold">Total</div>
                        <h1 class="font-semibold">{{$this->formattedTotal}}</h1>
                    </div>
                </div>

                <x-primary-button type="submit">Confirm order and pay</x-button>
            </div>
        </div>
    </div>
</form>

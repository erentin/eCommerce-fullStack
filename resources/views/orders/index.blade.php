<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Siparişler
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg space-y-3">
                @forelse ($orders as $order)
                <div class="bg-white p-6 col-span-4 space-y-3">
                    <div class="border-b pb-3 flex items-center justify-between">
                        <div>{{$order->id}}</div>
                        <div>{{$order->subtotal}}</div>
                        <div>{{$order->shippingType->title}}</div>
                        <div>{{$order->created_at}}</div>

                        <div>
                            <span class="inline-flex items-center px-3 py-1 text-sm rounded-full font-semibold bg-gray-100 text-gray-800">

                              @if($order->status() === 'placed_at')
                                Sipariş Hazırlanıyor
                              @elseif($order->status() === 'packaged_at')
                                Sipariş Paketlendi
                              @elseif($order->status() === 'shipped_at')
                                Yola Çıktı
                              @endif
                            </span>
                        </div>
                    </div>


                    @foreach ($order->variations as $variation)    
                    <div class="border-b py-3 space-y-2 flex items-center last:border-0 last:pb-0">
                        
                            <div class="w-16 mr-4">
                                <img src="{{$variation->getFirstMediaUrl('default','200x200')}}" class="w-16">
                            </div>
                            <div class="space-y-1">
                                <div>
                                    <div class="font-semibold">{{$variation->formattedPrice()}}</div>
                                    <div>{{$variation->product->title}}</div>
                                </div>

                                <div class="flex items-center text-sm">
                                    <div class="mr-1 font-semibold">
                                        Adet: {{$variation->pivot->quantity
                                        }} <span class="text-gray-400 mx-1">/</span>
                                    </div>
                                    @foreach ($variation->ancestorsAndSelf as $ancestor)      
                                        {{$ancestor->title}} @if (!$loop->last)<span class="text-gray-400 mx-1">/</span> @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
                @empty
                    <h1>Herhangi bir sipariş kaydı bulunamamaktadır!</h1>
                @endforelse
                <!-- Each order -->
            </div>
        </div>
    </div>
</x-app-layout>
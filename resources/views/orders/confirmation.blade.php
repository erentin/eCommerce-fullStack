<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Siparişiniz için teşekkürler.
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Teşekkürler, {{$order->id}} numaralı siparişin verildi.

                    Siparişlerini yönetmek ve görüntülemek için <a href="/register" class="text-indigo-500">Kayıt Ol!</a> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

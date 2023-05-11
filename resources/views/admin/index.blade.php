
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @livewireStyles

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
      
        <!-- This is an example component -->
<div>
      <x-admin-navbar/>
   <div class="flex overflow-hidden bg-white pt-16">
      
      <x-sidebar/>

      <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
      <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64">
         <main>
            <div class="pt-6 px-4">
               <div class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-1 gap-4">
                  
                  <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                     <div class="mb-4 flex items-center justify-between">
                        <div>
                           <h3 class="text-xl font-bold text-gray-900 mb-2">Son Siparişler</h3>
                           <span class="text-base font-normal text-gray-500">Son 30 Günün Siparişleri Gözükmektedir</span>
                        </div>
                        <div class="flex-shrink-0">
                           <a href="#" class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg p-2">Hepsini İncele</a>
                        </div>
                     </div>
                     <div class="flex flex-col mt-8">
                        <div class="overflow-x-auto rounded-lg">
                           <div class="align-middle inline-block min-w-full">
                              <div class="shadow overflow-hidden sm:rounded-lg">
                                 <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                       <tr>
                                          <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                             Kimden
                                          </th>
                                          <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            E-Mail
                                         </th>
                                          <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                             Zaman
                                          </th>
                                          <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kargo Firması
                                         </th>
                                          <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                             Miktar
                                          </th>
                                          <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                             Detay
                                          </th>
                                       </tr>
                                    </thead>
                                    @foreach($orders->take(10) as $order)
                                    <tbody class="bg-white">
                                       <tr>
                                       
                                          @if($order->user)
                                          <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-900">
                                            <span class="font-semibold">{{$order->user->name}}</span> (Kullanıcı)
                                          </td>
                                          @else 
                                          <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-900">
                                            <span class="font-semibold">Ziyaretçi Üye</span>
                                          </td>
                                          @endif
                                          <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-900">
                                            {{$order->email}}
                                          </td>
                                          <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500">
                                             {{$order->created_at->diffForHumans()}}
                                          </td>
                                          <td class="p-4 whitespace-nowrap text-sm font-normal text-gray-500">
                                            {{$order->shippingType->title}}
                                         </td>
                                         <td class="p-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                           {{$order->subtotal + $order->shippingType->price}}₺
                                         </td>
                                         <td class="p-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                          <a href="{{route('admin-order',$order->id)}}">DETAYA GİT</a>
                                        </td>
                                       
                                       </tr>
                                    </tbody>
                                   @endforeach
                                 </table>
                                 {{$orders->links()}}
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  
               </div>
               <div class="mt-4 w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                  <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                     <div class="flex items-center">
                        <div class="flex-shrink-0">
                           <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{$users->count()}}</span>
                           <h3 class="text-base font-normal text-gray-500">Toplam Kayıtlı Kullanıcı</h3>
                        </div>
                     </div>
                  </div>
                  <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                     <div class="flex items-center">
                        <div class="flex-shrink-0">
                           <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{$carts->count()}}</span>
                           <h3 class="text-base font-normal text-gray-500">Son 30 Gündeki Toplam Ziyaretçi Sayısı</h3>
                        </div>
                        
                     </div>
                  </div>
                  <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                     <div class="flex items-center">
                        <div class="flex-shrink-0">
                           <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">{{$ordersTotalCount}}</span>
                           <h3 class="text-base font-normal text-gray-500">Son 30 Gündeki Toplam Sipariş Sayısı</h3>
                        </div>
                        
                     </div>
                  </div>
               </div>
               <div class="grid grid-cols-1 2xl:grid-cols-2 xl:gap-4 my-4">
                  <div class="bg-white shadow rounded-lg mb-4 p-4 sm:p-6 h-full">
                     <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold leading-none text-gray-900">Son Üye Olan Kullanıcılar</h3>
                        <a href="#" class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg inline-flex items-center p-2">
                        Tümünü Görüntüle
                        </a>
                     </div>
                     <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200">
                          @foreach($users->take(10) as $user)
                           <li class="py-3 sm:py-4">
                              <div class="flex items-center space-x-4">
                                 <div class="flex-shrink-0">
                                    <img class="h-8 w-8 rounded-full" src="https://cdn.avixa.org/production/images/default-source/icons/just-for-you-icon.png?sfvrsn=3c0f0e5b_6" alt="Neil image">
                                 </div>
                                 <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                       {{$user->name}}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate">
                                       <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="17727a767e7b57607e7973646372653974787a">[email&#160;protected]</a>
                                    </p>
                                 </div>
                                 <div class="inline-flex items-center text-base font-semibold text-gray-900">
                                    {{$user->created_at->diffForHumans()}}
                                 </div>
                              </div>
                           </li>
                           @endforeach
                        </ul>
                     </div>
                  </div>
                  <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                     <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl leading-none font-bold text-gray-900 mb-10">Stok Durumları</h3>
                        <a href="#" class="text-sm font-medium text-cyan-600 hover:bg-gray-100 rounded-lg inline-flex items-center p-2">
                           Tümünü Görüntüle
                        </a>
                     </div>
                     <div class="block w-full overflow-x-auto">
                        <table class="items-center w-full bg-transparent border-collapse">
                           <thead>
                              <tr>
                                 <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">Ürün / Boyut / Renk</th>
                                 <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap">Stok Miktarı</th>
                                 {{-- <th class="px-4 bg-gray-50 text-gray-700 align-middle py-3 text-xs font-semibold text-left uppercase border-l-0 border-r-0 whitespace-nowrap min-w-140-px">Stok Yüzdesi</th> --}}
                              </tr>
                           </thead>
                           <tbody class="divide-y divide-gray-100">
                              @foreach ($stocks->take(10) as $stock)
                              <tr class="text-gray-500">
                                <th class="border-t-0 px-4 align-middle text-sm font-normal whitespace-nowrap p-4 text-left">{{$stock->variation->product->title}} - {{$stock->variation->title}} - {{$stock->variation->find($stock->variation->parent_id)->title}} </th>
                                <td class="border-t-0 px-4 align-middle text-xs font-medium text-gray-900 whitespace-nowrap p-4">{{$stock->variation->stockCount()}}</td>
                                <td class="border-t-0 px-4 align-middle text-xs whitespace-nowrap p-4">
                                  {{-- <div class="flex items-center">
                                    <span class="mr-2 text-xs font-medium">{{$stock->variation->stockCount()}}%</span>
                                    <div class="relative w-full">
                                      <div class="w-full bg-gray-200 rounded-sm h-2">
                                        <div class="bg-cyan-600 h-2 rounded-sm" style="width: {{ $stock->variation->stockCount() }}%"></div>
                                      </div>
                                    </div>
                                  </div> --}}
                                </td>
                              </tr>
                              @endforeach
                              

                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </main>
         

         <x-admin-footer/>

      </div>
   </div>
   <script async defer src="https://buttons.github.io/buttons.js"></script>
   <script src="https://demo.themesberg.com/windster/app.bundle.js"></script>
</div>

    </body>
</html>

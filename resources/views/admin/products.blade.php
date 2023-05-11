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
                                       </tr>
                                    </thead>
                                    @foreach($orders as $order)
                                    <tbody class="bg-white">
                                      <a href="/cart">
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
                                       </tr>
                                      </a>
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

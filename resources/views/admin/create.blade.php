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
                              <h3 class="text-xl font-bold text-gray-900 mb-2">Ürün Yükle</h3>
                              <span class="text-base font-normal text-gray-500">Ürün Görsel ve Varyasyonları Varyasyon Yükle Bölümünden Yapılmaktadır.</span>
                           </div>
                        </div>
                        
                        <div class="flex flex-col mt-8">
                           <form action="{{route('admin-product-store')}}" method="POST">
                              <div class="mb-6">
                                 @csrf
                                 <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                 <input name="title" type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              </div>
                              <div class="mb-6">
                                 <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
                                 <input name="slug" type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              </div>
                              
                         
                              <div>

                                 <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                 <textarea name="description" id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>

                              </div>
                              <div class="mb-6">
                                 <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                 <input name="price" type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              </div>
                              <div>
                                 <label for="">Yüklenme Tarihi</label>
                                 <input name="liveAt" type="text" id="disabled-input" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{now()}}" disabled>
                              </div>
                              <div>
                                 <input type="submit" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700" value="EKLE"/>
                              </div>
                           </form>
                        </div>

                        
                     </div>
                     <div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 ">
                        <div class="mb-4 flex items-center justify-between">
                           <div>
                              <h3 class="text-xl font-bold text-gray-900 mb-2">Varyasyon Yükle</h3>
                              <span class="text-base font-normal text-gray-500">Ürün Ekledikten Sonra Ürünün Alt Varyasyon ve Çeşitleri Bu Bölümden Eklenir.</span>
                           </div>
                        </div>
                        
                        <div class="flex flex-col mt-8">
                           <form action="{{route('admin-variation-store')}}" method="POST">
                              @csrf
                              <div class="mb-6">
                                 <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ürün ID</label>
                                 <input name="productId" type="number" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              </div>
                              <div class="mb-6">
                                 <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Varyasyon Başlığı</label>
                                 <input name="title" type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              </div>
                              <div class="mb-6">
                                 <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Fiyat</label>
                                 <input name="price" type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              </div>
                              <div class="mb-6">
                                 <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Varyasyon Tipi</label>
                                 <select name="type" type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="{{null}}" disabled selected>Bir Seçim Yapınız</option>
                                    <option value="boyut">Boyut</option>
                                    <option value="renk">Renk</option>
                                 </select>
                              </div>
                              <div class="mb-6">
                                 <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Varyasyon Stok Kodu</label>
                                 <input name="sku" type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              </div>
                              <div class="mb-6">
                                 <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Varyasyonun Bağlı Olduğu Üst Üye</label>
                                 <input name="parentId" type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              </div>             
                              <div class="mb-6">
                                 <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Varyasyon Önem Sırası</label>
                                 <input name="order" type="text" id="base-input" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              </div>
                              <div>
                                 <label for="">Oluşturulma Tarihi</label>
                                 <input name="createdAt" type="text" id="disabled-input" aria-label="disabled input" class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 cursor-not-allowed dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{now()}}" disabled>
                              </div>
                              <div>
                                 <input type="submit" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700" value="EKLE"/>
                              </div>
                           </form>
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

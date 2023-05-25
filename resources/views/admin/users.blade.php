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
                        {{$users->links()}}
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

<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-100 font-vazir" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : 'translate-x-full'" class="fixed inset-y-0 right-0 z-30 w-64 bg-slate-900 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                    <span class="text-white text-2xl font-semibold">دانیال کالا</span>
                </div>
            </div>

            <nav class="mt-10 px-4">
                <a class="flex items-center mt-4 py-2 px-6 rounded-lg {{ Request::is('admin') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}" href="{{ route('home.admin') }}">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="mx-3">داشبورد</span>
                </a>

                <a class="flex items-center mt-4 py-2 px-6 rounded-lg {{ Request::is('admin/products*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}" href="{{ route('products.index') }}">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="mx-3">محصولات</span>
                </a>

                <a class="flex items-center mt-4 py-2 px-6 rounded-lg {{ Request::is('admin/category*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}" href="{{ route('category.index') }}">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span class="mx-3">دسته‌بندی‌ها</span>
                </a>

                <a class="flex items-center mt-4 py-2 px-6 rounded-lg {{ Request::is('admin/user*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}" href="{{ route('user.index') }}">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="mx-3">کاربران</span>
                </a>

                <a class="flex items-center mt-4 py-2 px-6 rounded-lg {{ Request::is('admin/orders*') ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:bg-gray-700 hover:text-white' }}" href="{{ route('orders.index') }}">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span class="mx-3">سفارشات</span>
                </a>

                <a class="flex items-center mt-4 py-2 px-6 rounded-lg text-gray-400 hover:bg-gray-700 hover:text-white" href="/" target="_blank">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span class="mx-3">مشاهده فروشگاه</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-indigo-600">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

                <div class="flex items-center">
                    <div x-data="{ dropdownOpen: false }" class="relative">
                        <button @click="dropdownOpen = ! dropdownOpen" class="relative block h-8 w-8 rounded-full overflow-hidden shadow focus:outline-none">
                            <img class="h-full w-full object-cover" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=6366f1&color=fff" alt="Avatar">
                        </button>

                        <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute left-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-10">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">پروفایل</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">خروج</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <h3 class="text-gray-700 text-3xl font-medium">@yield('title')</h3>
                    <div class="mt-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>

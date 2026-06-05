<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دانیال کالا - @yield('title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-50 font-vazir text-gray-900">
    <!-- Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center space-x-8 space-x-reverse">
                    <a href="/" class="text-2xl font-bold text-indigo-600">دانیال کالا</a>
                    <nav class="hidden md:flex space-x-6 space-x-reverse">
                        <a href="/" class="hover:text-indigo-600 transition">صفحه اصلی</a>
                        <a href="/shop" class="hover:text-indigo-600 transition">فروشگاه</a>
                        <a href="#" class="hover:text-indigo-600 transition">دسته بندی ها</a>
                    </nav>
                </div>

                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="relative hidden md:block">
                        <input type="text" placeholder="جستجو در محصولات..." class="bg-gray-100 border-none rounded-full py-2 px-10 focus:ring-2 focus:ring-indigo-500 w-64">
                        <svg class="h-5 w-5 text-gray-400 absolute right-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <a href="/cart" class="relative p-2 text-gray-600 hover:text-indigo-600 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="absolute top-0 left-0 bg-indigo-600 text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center">0</span>
                    </a>

                    @auth
                        <a href="/profile" class="text-gray-600 hover:text-indigo-600 transition">پنل کاربری</a>
                    @else
                        <a href="/login" class="bg-indigo-600 text-white px-6 py-2 rounded-full hover:bg-indigo-700 transition">ورود / ثبت‌نام</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12 mt-20">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <h3 class="text-white text-xl font-bold mb-4">درباره دانیال کالا</h3>
                <p class="leading-relaxed">دانیال کالا بزرگترین فروشگاه اینترنتی منطقه، با ارائه بهترین محصولات دیجیتال و لوازم خانگی با گارانتی معتبر و ارسال سریع در خدمت شماست.</p>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4">لینک‌های مفید</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-white transition">قوانین و مقررات</a></li>
                    <li><a href="#" class="hover:text-white transition">سوالات متداول</a></li>
                    <li><a href="#" class="hover:text-white transition">درباره ما</a></li>
                    <li><a href="#" class="hover:text-white transition">تماس با ما</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white text-lg font-bold mb-4">ارتباط با ما</h3>
                <p>تلفن: ۰۲۱-۱۲۳۴۵۶۷۸</p>
                <p>ایمیل: info@danialkala.com</p>
                <div class="flex space-x-4 space-x-reverse mt-4">
                    <!-- Social icons -->
                </div>
            </div>
        </div>
        <div class="container mx-auto px-4 mt-12 pt-8 border-t border-gray-800 text-center text-sm">
            تمامی حقوق این سایت متعلق به دانیال کالا می‌باشد.
        </div>
    </footer>
    @stack('scripts')
</body>
</html>

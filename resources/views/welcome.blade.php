@extends('layouts.store')

@section('title', 'فروشگاه اینترنتی')

@section('content')
<!-- Hero Slider Simulation -->
<section class="relative bg-gray-200 h-[400px] overflow-hidden">
    @php $sliders = App\Models\Slider::all(); @endphp
    <div class="container mx-auto px-4 h-full flex items-center relative">
        <div class="z-10 max-w-lg">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">تکنولوژی در دستان شما</h1>
            <p class="text-lg text-gray-600 mb-8">جدیدترین گوشی‌های هوشمند و لپ‌تاپ‌ها با تخفیف‌های ویژه جشنواره بهاره</p>
            <a href="/shop" class="bg-indigo-600 text-white px-8 py-3 rounded-lg text-lg font-bold hover:bg-indigo-700 transition">همین حالا خرید کنید</a>
        </div>
        <div class="absolute inset-0 bg-gradient-to-l from-transparent to-gray-200 lg:bg-none"></div>
        <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" class="absolute left-0 top-0 h-full w-1/2 object-cover hidden lg:block" alt="Hero">
    </div>
</section>

<!-- Categories -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-10 text-center">دسته‌بندی‌های محبوب</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach(App\Models\Category::all() as $cat)
            <a href="#" class="group text-center">
                <div class="bg-gray-100 rounded-2xl p-6 mb-4 group-hover:bg-indigo-50 transition duration-300">
                    <img src="https://ui-avatars.com/api/?name={{ $cat->name }}&background=6366f1&color=fff&size=128" class="mx-auto h-16 w-16" alt="{{ $cat->name }}">
                </div>
                <h3 class="font-bold group-hover:text-indigo-600 transition">{{ $cat->name }}</h3>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-2xl font-bold">جدیدترین محصولات</h2>
            <a href="/shop" class="text-indigo-600 font-semibold hover:underline">مشاهده همه</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach(App\Models\Product::latest()->take(8)->get() as $product)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300">
                <a href="{{ route('product.show', $product->id) }}" class="block p-4">
                    <img src="https://ui-avatars.com/api/?name={{ $product->name }}&background=f3f4f6&color=6366f1&size=512" class="w-full aspect-square object-cover rounded-xl mb-4" alt="{{ $product->name }}">
                    <h3 class="font-bold text-gray-800 mb-2 truncate">{{ $product->name }}</h3>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">{{ $product->subcategory->name }}</span>
                        <div class="text-indigo-600 font-bold">
                            {{ number_format($product->stores->first()->price_sell ?? 0) }} تومان
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Banners -->
<section class="py-16 container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-indigo-600 rounded-3xl p-8 md:p-12 text-white flex flex-col justify-center">
            <h2 class="text-3xl font-bold mb-4">تخفیف ویژه محصولات اپل</h2>
            <p class="text-indigo-100 mb-8">تا ۴۰ درصد تخفیف برای مدت محدود در جشنواره تابستانه دانیال کالا</p>
            <a href="#" class="bg-white text-indigo-600 px-8 py-3 rounded-xl font-bold w-max hover:bg-gray-100 transition">مشاهده محصولات</a>
        </div>
        <div class="bg-slate-900 rounded-3xl p-8 md:p-12 text-white flex flex-col justify-center">
            <h2 class="text-3xl font-bold mb-4">لوازم جانبی حرفه‌ای</h2>
            <p class="text-gray-400 mb-8">تجهیزات گیمینگ و لوازم جانبی موبایل با گارانتی تعویض کالا</p>
            <a href="#" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold w-max hover:bg-indigo-700 transition">فروش ویژه</a>
        </div>
    </div>
</section>
@endsection

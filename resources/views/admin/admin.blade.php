<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <title>@yield('title')</title>
</head>
<body>
<div class="container-fluid cp-admin-container">

    <nav class="navbar navbar-dark bg-dark navbar-expand-lg">

        <div class="container-fluid">
            <a class="navbar-brand m-1">مدیریت اپلیکشین</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav mr-auto">

                    <li class="nav-item dropdown">


                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="">خروج</a>
                        </div>

                    </li>

                </ul>

            </div>

            <a class="nav-link dropdown-toggle" style="color: white" href="#" id="navbarDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                admin
            </a>

        </div>
    </nav>

    <div class="row">
        {{--        menu--}}
        <div class="col-12 col-md-2">
            <div class="accordion" id="accordionExample">
                <ul style="padding-right: 0">

                    <li class="cp-admin-menu" style="background-color: #9fcdff">
                        <a href="{{route('home.admin')}}" class="text-decoration-none" style="color: black">داشبورد</a>
                    </li>

                    <li class="cp-admin-menu "
                        style="background-color: #ff4242"
                        data-bs-toggle="collapse"
                        href="#item_user_management"
                        aria-expanded="false"
                        aria-controls="item_user_management">
                        <span class="text-decoration-none" style="color: black">مدیریت کاربران</span>
                    </li>
                    <div class="collapse multi-collapse" id="item_user_management">
                        <ul class="cp-admin-menu-ul">

                            <li><a href="{{route('user.index')}}" class="text-decoration-none">نمایش</a></li>

                            <li><a href="{{route('user.create')}}" class="text-decoration-none">افزودن</a></li>

                        </ul>
                    </div>


                    <li class="cp-admin-menu "
                        style="background-color: #a6ffff"
                        data-bs-toggle="collapse"
                        href="#item_product_management"
                        aria-expanded="false"
                        aria-controls="item_product_management">
                        <span class="text-decoration-none" style="color: black">مدیریت محصولات</span>
                    </li>
                    <div class="collapse multi-collapse" id="item_product_management">
                        <ul class="cp-admin-menu-ul">
                            <li><a href="{{route('products.index')}}" class="text-decoration-none">نمایش محصولات</a>
                            </li>
                            <li><a href="{{route('products.create')}}" class="text-decoration-none">افزودن محصول</a>
                            </li>

                            <li class="cp-admin-menu "
                                style="background-color: #6f42c1;">
                                <a href="{{route('color.index')}}"
                                   class="text-decoration-none color-white">
                                    رنگ ها
                                </a>
                            </li>

                            <li class="cp-admin-menu "
                                style="background-color: #2d3748;">
                                <a href="{{route('brand.index')}}"
                                   class="text-decoration-none color-white">
                                    برند ها
                                </a>
                            </li>

                            <li class="cp-admin-menu "
                                style="background-color: #69ff99">
                                <a href="{{route('category.index')}}"
                                   class="text-decoration-none color-black">مدیریت
                                    دسته
                                    بندی</a>
                            </li>


                        </ul>
                    </div>


                    <li class="cp-admin-menu "
                        style="background-color: #3856ff"
                        data-bs-toggle="collapse"
                        href="#item_media_management"
                        aria-expanded="false"
                        aria-controls="item_media_management">
                        <span class="text-decoration-none" style="color: black">مدیریت رسانه</span>
                    </li>
                    <div class="collapse multi-collapse" id="item_media_management">
                        <ul class="cp-admin-menu-ul">
                            <li><a href="" class="text-decoration-none">نمایش رسانه</a></li>
                            <li><a href="" class="text-decoration-none">افزودن رسانه</a></li>
                        </ul>
                    </div>

                    <li class="cp-admin-menu "
                        style="background-color: #2effe1"
                        data-bs-toggle="collapse"
                        href="#item_slider_management"
                        aria-expanded="false"
                        aria-controls="item_slider_management">
                        <span class="text-decoration-none" style="color: black">اسلایدر</span>
                    </li>
                    <div class="collapse multi-collapse" id="item_slider_management">
                        <ul class="cp-admin-menu-ul">

                            <li>
                                <a href="{{route('slider.index')}}" class="text-decoration-none">نمایش اسلایدر</a>
                            </li>

                            <li>
                                <a href="{{route('slider.create')}}" class="text-decoration-none">افزودن اسلایدر</a>
                            </li>

                        </ul>
                    </div>


                </ul>
            </div>
        </div>

        {{--        content--}}

        <div class="col-12 col-md-10 cp-admin-content" style="direction: rtl !important;">

            <div class="card w-100 mb-5">

                <div class="card-header">
                    @yield('title')
                </div>
                <div class="p-3">
                    @yield('content')
                </div>

            </div>

        </div>

    </div>
</div>
<script src="{{asset("js/jquery.js")}}"></script>
<script src="{{asset("js/bootstrap.min.js")}}"></script>
<script src="{{asset("js/dropzone.min.js")}}"></script>
<script>
    const category = document.querySelector("#category_parent");
    const subCategory = document.querySelector('#sub_categorys');
    category.addEventListener("change", function () {
        let val = category.value;
        $.ajax({
            type: 'POST',
            url: '<?php echo route("get.sub_category") ?>',
            data: {_token: '<?php echo csrf_token() ?>', id: val},
            success: function (data) {
                let option = ``;
                data.forEach(e => {
                    option += `<option value='${e.id}'>${e.name}</option>`;
                })
                subCategory.innerHTML = option;
            }
        });
    })
</script>
</body>
</html>

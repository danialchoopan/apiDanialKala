<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>آپلود عکس محصول</title>
    <link href="{{asset("css/dropzone.min.css")}}" rel="stylesheet">
    <link href="{{asset("css/drop_img.css")}}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .remove_icon_img {
            visibility: hidden;
            color: red;
            transform: scale(1);
            position: absolute;
            top: -10px;
            left: -10px;
            cursor: pointer;
            transition: all 0.3s ;
        }

        .show_icon:hover > .remove_icon_img{

            visibility: visible;
            transform: scale(1.6);
            top: 10px;
            left: 10px;
        }


    </style>
</head>
<body>
<div class="tab-block" id="tab-block">
    <a style="background-color: #0f6ecd;color: white;padding: 10px 15px;margin: 10px;border-radius: 10px ;text-decoration: none" href="{{route("products.index")}}">بازگشت به لیست محصولات</a>
    <span style="background-color: #0f6ecd;color: white;padding: 10px 15px;margin: 10px;border-radius: 10px ;" >تصاویر محصول شماره  {{ $productId }}</span>
    <ul class="tab-mnu">
        <li class="active">آپلود</li>
        <li id="tab_pics">تصاویر</li>
    </ul>
    <div class="tab-cont">
        <div class="tab-pane">
            <div class="tab-pane active" id="firsttab">
                <form action="{{route("upload.img.product.img.upload",$productId)}}" class="dropzone" id="from_upload"
                      method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="fallback">
                        <input name="file" type="file" multiple/>
                    </div>
                    <div class="dz-message" data-dz-message><span>تصاویر خود را در اینجا رها کنید !</span></div>
                </form>
            </div>
        </div>
        <div class="tab-pane" id="panel_pics">
            <!-- load imgs here -->
        </div>
    </div>
</div>
<script src="{{asset("js/jquery.js")}}"></script>
<script src="{{asset("js/drop_img.js")}}"></script>
<script src="{{asset("js/dropzone.min.js")}}"></script>
<script src="{{asset("js/sweetalert.min.js")}}"></script>
<script>
    new Dropzone("#from_upload", {
        acceptedFiles: "image/*"
    });
    const tabPics = document.querySelector("#tab_pics")
    const panel_pics = document.querySelector("#panel_pics")
    panel_pics.addEventListener('click', (e) => {
        if(e.target.classList.contains('remove_icon_img')){

            let id_img_thumbnail = e.target.getAttribute('data-id');
            $.ajax({
                type: 'POST',
                url: '<?php echo route("change.thumbnail.product.delete") ?>',
                data: {_token: '<?php echo csrf_token() ?>', id: id_img_thumbnail},
                success: function (data) {
                    swal({
                        title: "تصویر",
                        text: "تصویر  محصول با موفقیت حذف  شد",
                        icon: "info",
                        button: "باشه! :-(",
                    });
                }
            });
            load_imgs()
        }
        if (e.target.getAttribute('data-id') != null) {
            let id_img_thumbnail = e.target.getAttribute('data-id');
            $.ajax({
                type: 'POST',
                url: '<?php echo route("change.thumbnail.product") ?>',
                data: {_token: '<?php echo csrf_token() ?>', id: id_img_thumbnail},
                success: function (data) {
                    swal({
                        title: "تصویر شاخص",
                        text: "تصویر شاخص محصول با موفقیت تغییر کرد",
                        icon: "success",
                        button: "باشه!",
                    });
                }
            });
            load_imgs()
        }
    })

    tabPics.addEventListener("click", function () {
        load_imgs()
    })
    function load_imgs(){
        $.ajax({
            type: 'POST',
            url: '<?php echo route("get.product.img") ?>',
            data: {_token: '<?php echo csrf_token() ?>', id: <?php echo $productId ?>},
            success: function (data) {
                let imgBoxs = ``;
                data.forEach(e => {
                    console.log(e.thumbnail)
                    if (e.thumbnail == 1) {
                        imgBoxs += `<div class="show_icon" style="border: 3px red dashed;padding:10px ;display: inline-block;width: 20%;position: relative" >
                                        <i class="large material-icons remove_icon_img" data-id="${e.id}" >delete</i>
                                        <img width="99%" data-id="${e.id}" src="/img/${e.path}">
                                    </div>`;
                    } else {
                        imgBoxs += `<div class="show_icon" style="padding:10px ;display: inline-block;width: 20%;position: relative" >
                                        <i class="large material-icons remove_icon_img" data-id="${e.id}" >delete</i>
                                        <img width="99%" data-id="${e.id}" src="/img/${e.path}">
                                    </div>`;
                    }
                })
                panel_pics.innerHTML = imgBoxs;
            }
        });
    }
</script>
</body>
</html>


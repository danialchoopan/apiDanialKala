<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>افزودن نقد محصول</title>
    {{--    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">--}}

    <style>
        * {
            direction: rtl;
        }

        body {
            background-color: #4c607c;
        }

        .panel {
            background-color: whitesmoke;
            border-radius: 3px;
            padding: 10px;
            margin-top: 15px;
        }

        .btn_review {
            background-color: #0f6ecd;
            color: white;
            padding: 10px 15px;
            margin: 10px;
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div style="position: fixed;top: 0;left: 0;right: 0;background-color: #4c607c;padding: 10px">
    <a class="btn_review" href="{{route("products.index")}}">بازگشت به لیست محصولات</a>
    <span class="btn_review">تفد محصول شماره  {{ $productId }}</span>
    <span class="btn_review" id="save_changes">ذخیره تغییرات</span>
</div>
<div class="panel" style="margin-top: 50px">

    {{--    rich text editor--}}
    <textarea id="editor">{{$review->review}}</textarea>
</div>
<script src="{{asset("js/jquery.js")}}"></script>
<script src="{{asset("js/sweetalert.min.js")}}"></script>
<script src="{{asset("js/ckeditor.js")}}"></script>
<script>
    let ClassicEditor_data;
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then( newEditor => {
            ClassicEditor_data = newEditor;
        } )
        .catch(error => {
            console.error(error);
        });
    let save_changes = document.querySelector("#save_changes")
    let text_editor = document.querySelector("#editor")
    save_changes.addEventListener("click", function () {
        $.ajax({
            type: 'POST',
            url: '<?php echo route("change.review.product") ?>',
            data: {_token: '<?php echo csrf_token() ?>', id_product: <?php echo $productId ?>, text: ClassicEditor_data.getData()},
            success: function (data) {
                swal({
                    title: "نقد",
                    text: "تقد شما با موفقیت ذخیره شد",
                    icon: "success",
                    button: "باشه!",
                });
            }
        });
    })
</script>
</body>
</html>


@extends('admin.admin')
@section('title','بروزرسانی اسلایدر')
@section('content')
    <div class="row">
        <div class="col-sm-4">
            <img src="{{env('APP_URL')."storage/".$slider->photo->path}}" width="100%" alt="">
        </div>
        <div class="col-sm-8">
            <form action="{{route('slider.update',$slider->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <fieldset class="form-group mb-3">
                    <label>عنوان</label>
                    <input class="form-control" name="slider_title"
                           value="{{$slider->title}}"
                           placeholder="عنوان را وارد کنید ..." >
                </fieldset>

                <fieldset class="form-group mb-3">
                    <label>بنر</label>
                    <input type="file" class="form-control" name="slider_photo">
                </fieldset>

                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit">بروزرسانی</button>
                </div>
            </form>
        </div>
    </div>
@endsection

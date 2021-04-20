@extends('admin.admin')
@section('title','افزودن اسلایدر')
@section('content')

    <form action="{{route('slider.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <fieldset class="form-group mb-3">
            <label>عنوان</label>
            <input class="form-control" name="slider_title" placeholder="عنوان را وارد کنید ...">
        </fieldset>

        <fieldset class="form-group mb-3">
            <label>بنر</label>
            <input type="file" class="form-control" name="slider_photo">
        </fieldset>

        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit">افزودن محصول</button>
        </div>
    </form>
@endsection

@extends("admin.admin")
@section('title','افزودن پست')
@section('title_content')
    <i class="fa fa-pause fa-plus"></i>
    افزودن پست
@endsection
@section("body_content")

    <form action="{{route("posts.store")}}" method="post" enctype="multipart/form-data">
        @include("include.formErrors")
        @csrf
        <input type="hidden" name="_method" value="POST">
        <fieldset class="form-group">
            <label>عنوان</label>
            <input class="form-control" name="post_title" placeholder="عنوان را وارد کنید ...">
        </fieldset>
        <fieldset class="form-group">
            <label>دسته بندی</label>
            <select name="select_category" class="form-control">
                <option value="0">دسته بندی نشده !</option>
                @foreach($categorys as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </fieldset>
        <fieldset class="form-group">
            <label>عکس</label>
            <input type="file" name="post_photo" class="form-control">
        </fieldset>
        <fieldset class="form-group">
            <label>بدنه</label>
            <textarea class="form-control" name="post_body" rows="9"></textarea>
        </fieldset>
        <input type="submit" value="افزودن پست" class="btn btn-primary">
    </form>
@endsection

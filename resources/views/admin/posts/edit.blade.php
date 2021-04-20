@extends("admin.admin")
@section('title','افزودن پست')
@section('title_content')
    <i class="fa fa-pause fa-plus"></i>
    افزودن پست
@endsection
@section("body_content")
    <div class="col-sm-3">
        <img width="99%" src="{{$post->photo ? $post->photo->path:"https://placehold.co/400x400"}}" alt="">
    </div>
    <form action="{{route("posts.update",$post->id)}}" class="col-sm-9" method="post" enctype="multipart/form-data">
        @include("include.formErrors")
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <fieldset class="form-group">
            <label>عنوان</label>
            <input class="form-control" name="post_title" placeholder="عنوان را وارد کنید ..." value="{{$post->title}}">
        </fieldset>
        <fieldset class="form-group">
            <label>دسته بندی</label>
            <select name="select_category" class="form-control">
                <option value="0">دسته بندی نشده !</option>
                @foreach($categorys as $category)
                    @if($category->id==$post->category_id)
                        <option value="{{$category->id}}" selected>{{$category->name}}</option>
                    @endif
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
            <textarea class="form-control" name="post_body" rows="9">{{$post->body}}</textarea>
        </fieldset>
        <input type="submit" value="بروزرسانی پست" class="btn btn-primary">
    </form>
    <form action="{{route('posts.destroy',$post->id)}}" method="post">
        @csrf
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" value="پاک کردن" class="btn btn-danger">
    </form>
@endsection

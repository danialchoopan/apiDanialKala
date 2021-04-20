@extends("admin.admin")
@section('title','رسانه ها')
@section('title_content')
    <i class="fa fa-pause fa-fw"></i>
    رسانه ها
@endsection
@section("body_content")
    @include('include.messageAlertSessions')
    <div class="table-responsive">
        <form action="{{route("media.store")}}" method="post" enctype="multipart/form-data" class="dropzone">
            @include("include.formErrors")
            @csrf
            <input type="hidden" name="_method" value="POST" >
{{--            <fieldset class="form-group">--}}
{{--                <label>فایل</label>--}}
{{--                <input class="form-control" name="media_file" type="file">--}}
{{--            </fieldset>--}}
{{--            <input type="submit" value="افزودن رسانه" class="btn btn-primary">--}}
        </form>
    </div>
@endsection

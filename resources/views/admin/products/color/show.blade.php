@extends("admin.admin")
@section('title','بروزرسانی رنگ')
@section("content")
    <form action="{{route("color.update",$color->id)}}" method="post">
        @csrf
        @method('PATCH')
        <fieldset class="form-group mb-3">
            <label>نام</label>
            <input class="form-control" name="color_name" placeholder="نام را وارد کنید ..." value="{{$color->name}}">
        </fieldset>
        <fieldset class="form-group mb-3">
            <label>رنگ</label>
            <input class="form-control" type="color" name="color_hex"
                   value="{{$color->hex_code}}">
        </fieldset>
        <div class="d-grid gap-2 mb-3">
            <input type="submit" value="بروزرسانی رنگ" class="btn btn-primary">
        </div>
    </form>
@endsection

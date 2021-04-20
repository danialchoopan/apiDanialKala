@extends('admin.admin')
@section('title','رنگ ها')
@section('content')
    <div class="row">
        <div class="col-sm-3">
            <form action="{{route("color.store")}}" method="post">
                @csrf
                <fieldset class="form-group mb-3">
                    <label>نام</label>
                    <input class="form-control" name="color_name" placeholder="نام را وارد کنید ...">
                    <br>
                    <label>کد رنگ</label>
                    <input class="form-control" name="color_hex" type="color" placeholder="کد رنگ را وارد کنید ...">
                </fieldset>
                <div class="d-grid gap-2">
                    <input type="submit" value="افزودن رنگ" class="btn btn-primary">
                </div>
            </form>
        </div>
        <div class="col-sm-9">
            @if(count($colors)>0)
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>نام</th>
                        <th>hex</th>
                        <th>رنگ</th>
                        <th>ساخته شده در</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($colors as $color)
                        <tr>
                            <td>{{$color->id}}</td>
                            <td><a href="{{route('color.show',$color->id)}}">{{$color->name}}</a></td>
                            <td>{{$color->hex_code}}</td>
                            <td style="background-color: {{$color->hex_code}}"></td>
                            <td>{{$color->created_at->diffForHumans()}}</td>
                            <td>
                                <form action="{{route('color.destroy',$color->id)}}" method="post">
                                    @csrf
                                    @method("delete")
                                    <input type="submit" class="btn btn-danger" value="حذف">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>رنگی برای نمایش وجود نداره :-(</p>
            @endif
        </div>
    </div>
@endsection

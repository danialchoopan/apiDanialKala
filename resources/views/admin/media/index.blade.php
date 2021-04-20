@extends("admin.admin")
@section('title','رسانه ها')
@section('title_content')
    <i class="fa fa-pause fa-fw"></i>
    رسانه ها
@endsection
@section("body_content")
    @include('include.messageAlertSessions')
    <div class="table-responsive">
        @if(count($madias)>0)
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>آپلود شده توسط</th>
                    <th>ساخته شده در</th>
                </tr>
                </thead>
                <tbody>
                @foreach($madias as $media)
                    <tr>
                        <td>{{$media->id}}</td>
                        <td><img height="50" src="{{$media->path}}"></td>
                        <td>{{$media->created_at->diffForHumans()}}</td>
                        <td>
                            <form action="{{route('media.destroy',$media->id)}}" method="post">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" class="btn btn-danger" value="حذف">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>دسته بندی ای برای نمایش وجود ندارد :-(</p>
        @endif
    </div>
@endsection

@extends("admin.admin")
@section('title','نظر ها')
@section('title_content')
    <i class="fa fa-pause fa-fw"></i>
    نظر ها
@endsection
@section("body_content")
    @include('include.messageAlertSessions')
    <div class="table-responsive">
        پاسخ های
        @if(count($replies)>0)
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>کاربر</th>
                    <th>ایمیل</th>
                    <th>بدنه</th>
                    <th>پست</th>
                    <th>ارسال شده در</th>
                </tr>
                </thead>
                <tbody>
                @foreach($replies as $reply)
                    <tr>
                        <td>{{$reply->id}}</td>
                        <td>{{$reply->author}}</td>
                        <td>{{$reply->emial}}</td>
                        <td>{{$reply->body}}</td>
                        <td><a href="{{route('blog.show',$reply->comment->id)}}">{{$reply->comment->post->title}}</a></td>
                        <td>{{$reply->created_at->diffForHumans()}}</td>
                        <td>
                            <form action="{{route('replies.update',$reply->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_active" value="{{$reply->is_active}}">
                                @if($reply->is_active==0)
                                    <input type="submit" value="تایید" class="btn btn-success">
                                @else
                                    <input type="submit" value="غیر تایید !" class="btn btn-danger">
                                @endif
                            </form>
                        </td>
                        <td>
                            <form action="{{route('replies.destroy',$reply->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="حذف" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>دیدگاهی برای نمایش وجود ندارد :-(</p>
        @endif
    </div>
@endsection

@extends("admin.admin")
@section('title','نظر ها')
@section('title_content')
    <i class="fa fa-pause fa-fw"></i>
    نظر ها
@endsection
@section("body_content")
    <h1><a href="{{route('blog.show',$post->id)}}">{{$post->title}}</a></h1>
    @include('include.messageAlertSessions')
    <div class="table-responsive">
        نظرات
        @if(count($comments)>0)
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
                @foreach($comments as $comment)
                    <tr>
                        <td>{{$comment->id}}</td>
                        <td>{{$comment->author}}</td>
                        <td>{{$comment->emial}}</td>
                        <td>{{$comment->body}}</td>
                        <td><a href="{{route('blog.show',$comment->id)}}">{{$comment->post->title}}</a></td>
                        <td>{{$comment->created_at->diffForHumans()}}</td>
                        <td>
                            <form action="{{route('comments.update',$comment->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="is_active" value="{{$comment->is_active}}">
                                @if($comment->is_active==0)
                                    <input type="submit" value="تایید" class="btn btn-success">
                                @else
                                    <input type="submit" value="غیر تایید !" class="btn btn-danger">
                                @endif
                            </form>
                        </td>
                        <td>
                            <form action="{{route('comments.destroy',$comment->id)}}" method="post">
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

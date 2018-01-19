@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">
                                <a href="/profiles/{{ $thread->creator->name }}"> {{ $thread->creator->name }} </a> Posted:
                                    {{ $thread->title }}
                            </span>

                            @can('update',$thread)
                                <form action="{{ $thread->path() }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-link" type="submit">حذف</button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    <div class="panel-body">
                          {{ $thread->body }}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach
                {{ $replies->links() }}

                @if(auth()->check())
                    <form action="{{  $thread->path() . '/replies' }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                    <textarea name="body" id="body" class="form-control"
                              cols="30" rows="10" placeholder="نظر"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">ارسال نظر</button>
                    </form>
                @else
                    <p  class="text-center">برای مشارکت در بحث لطفا <a href="{{ route('login') }}">وارد </a> سایت شوید!</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        این بحث
                        {{ $thread->created_at->diffForHumans() }}
                        توسط  <a href="#">{{ $thread->creator->name }}</a>
                        ایجاد شده است و در حال حاضر
                        {{ $thread->replies_count }}
                        پاسخ دارد.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
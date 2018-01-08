@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#"> {{ $thread->creator->name }} </a> Posted:
                        {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                          {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form action="{{ route('add_reply', [ 'thread' => $thread ]) }}" method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" class="form-control"
                                      cols="30" rows="10" placeholder="نظر"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">ارسال نظر</button>
                    </form>
                </div>
            </div>
        @else
            <p>برای مشارکت در بحث لطفا <a href="{{ route('login') }}" class="text-center">وارد </a> سایت شوید!</p>
        @endif
    </div>
@endsection
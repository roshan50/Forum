@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>{{ $user->name }}</h4>
                        <small>Since {{ $user->created_at->diffForHumans() }}</small>
                    </div>

                    <div class="panel-body">
                        @foreach($threads as $thread)
                            <article>
                                <div class="level">
                                    <h4 class="flex">
                                        <a href="{{ $thread->path() }}">
                                            {{ $thread->title }}
                                        </a>
                                    </h4>
                                    <strong>{{ $thread->created_at->diffForHumans() }} </strong>
                                </div>
                                <div class="body"> {{ $thread->body }} </div>
                            </article>
                            <hr>
                        @endforeach
                        {{ $threads->links() }}
                    </div>
                </div>

            </div>


    </div>
@endsection
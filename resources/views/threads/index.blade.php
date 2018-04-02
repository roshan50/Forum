@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Forum Heading
                    </div>

                    <div class="panel-body">
                        @forelse($threads as $thread)
                            <article>
                                <div class="level">
                                    <div class="flex">
                                        <h4>
                                            <a href="{{ $thread->path() }}">
                                                @if(auth()->check() && $thread->hasUpdateFor(auth()->user()))
                                                    <strong>
                                                        {{ $thread->title }}
                                                    </strong>
                                                @else
                                                    {{ $thread->title }}
                                                @endif
                                            </a>
                                        </h4>

                                        <h5>پست شده توسط: <a href="{{ route('profile', $thread->creator) }}"> {{ $thread->creator->name }} </a></h5>
                                    </div>
                                    <strong>{{ $thread->replies_count }} پاسخ </strong>
                                </div>
                                <div class="body"> {!! $thread->body !!} </div>
                                <div class="panel-footer">
                                    {{ $thread->visits }} visit
                                </div>
                            </article>
                            <hr>
                            @empty
                            <p>no threads</p>
                        @endforelse
                    </div>
                </div>
                {{ $threads->render() }} <!-- this is for pagination-->
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Search
                    </div>
                    <div class="panel-body">
                        <form action="/threads/search" method="get">
                            <div class="form-group">
                                <input type="text" placeholder="search..." name="q" class="form-control">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-default" type="submit">search</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if(count($trending))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            trending threads
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                @foreach($trending as $thread)
                                    <li class="list-group-item">
                                        <a href="{{ url($thread->path) }}">
                                            {{ $thread->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
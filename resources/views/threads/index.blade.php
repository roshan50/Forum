@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Forum Heading
                    </div>

                    <div class="panel-body">
                        @forelse($threads as $thread)
                            <article>
                                <div class="level">
                                    <h4 class="flex">
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
                                    <strong>{{ $thread->replies_count }} پاسخ </strong>
                                </div>
                                <div class="body"> {{ $thread->body }} </div>
                            </article>
                            <hr>
                            @empty
                            <p>no threads</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
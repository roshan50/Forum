@extends('layouts.app')
@section('content')
    <thread-view inline-template :initial-replies-count="{{ $thread->replies_count }}">
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

                <replies :data="{{ $thread->replies }}"
                         @added="repliesCount++"
                         @removed="repliesCount--"></replies>


            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                        این بحث
                        {{ $thread->created_at->diffForHumans() }}
                        توسط  <a href="#">{{ $thread->creator->name }}</a>
                        ایجاد شده است و در حال حاضر
                        <span v-text="repliesCount"></span>
                        پاسخ دارد.
                        </p>

                        <p>
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </thread-view>
@endsection
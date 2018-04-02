@extends('layouts.app')
@section('header')
    <link href="/css/vendor/jquery.atwho.css" rel="stylesheet">
    <script>
        window.thread = <?= json_encode($thread) ?>
    </script>
@endsection
@section('content')
    <thread-view inline-template :thread="{{ $thread }}" >
    <div class="container">
        <div class="row">
            <div class="col-md-8">


                <div class="panel panel-default" v-if="editing">
                    <div class="panel-heading">
                        <div class="level">
                            <input type="text"  class="form-control" v-model="form.title">
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="form-group">
                            <wysiwyg v-model="form.body"></wysiwyg>
                            {{--<textarea name="body" class="form-control" rows="10" v-model="form.body"></textarea>--}}
                        </div>
                    </div>

                    <div class="panel-footer">
                        <button class="btn btn-primary" @click="update">ثبت</button>
                        <button class="btn btn-xs" @click="cancel">لغو</button>
                    </div>
                </div>



                <div class="panel panel-default" v-else>
                    <div class="panel-heading">
                        <div class="level">
                            <img src="{{ $thread->creator->avatar_path }}" width="25" height="25"
                                 alt="{{ $thread->creator->name }}" class="ml-1">
                            <span class="flex">
                                <a href="/profiles/{{ $thread->creator->name }}"> {{ $thread->creator->name }} </a> Posted:
                                    <span v-text="form.title"></span>
                            </span>
                        </div>
                    </div>

                    <div class="panel-body" v-html="form.body"></div>

                    <div class="panel-footer" v-if="authorize('owns',thread)">
                        <div class="flex">
                            <button class="btn btn-xs" @click="editing = true">ویرایش</button>

                            @can('update',$thread)
                                <form action="{{ $thread->path() }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-link mr-r" type="submit">حذف</button>
                                </form>
                            @endcan
                        </div>
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
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscribe-button>
                            <button class="btn btn-default"
                                    v-if="authorize('isAdmin')"
                                    @click="toggleLock"
                                    v-text="locked ? 'unLock' : 'lock'"></button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </thread-view>
@endsection
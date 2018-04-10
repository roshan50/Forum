@extends('layouts.app')
@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        ایجاد پست جدید
                    </div>

                    <div class="panel-body">
                        <form action="/threads" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="channel_id">انتخاب کانال</label>
                                <select class="form-control" name="channel_id" id="channel_id" required>
                                    <option value="">انتخاب کنید...</option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">عنوان</label>
                                <input type="text" name="title" id="title" required
                                       class="form-control" value="{{ old('title') }}">
                            </div>P
                            <div class="form-group">
                                <label for="body">متن</label>
                                <wysiwyg name="body"></wysiwyg>
                                {{--<textarea name="body" id="body" cols="30" required class="form-control"--}}
                                          {{--rows="10">{{ old('body') }}</textarea>--}}
                            </div>

                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LdyFk4UAAAAAJ-Qtp4LMNKe2KNsooZN2SurHiHf"></div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">ارسال</button>
                            </div>

                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
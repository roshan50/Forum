@extends('layouts.app')
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
                                <label for="title">عنوان</label>
                                <input type="text" name="title" id="title"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="body">متن</label>
                                <textarea name="body" id="body" cols="30"
                                          rows="10"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">ارسال</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
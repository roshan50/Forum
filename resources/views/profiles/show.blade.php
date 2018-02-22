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
                        @forelse($activities as $date => $activity)
                            <h3 class="page-header">{{ $date }}</h3>
                            @foreach($activity as $item)
                                @if(view()->exists("profiles.activities.{$item->type}"))
                                    @include("profiles.activities.{$item->type}" , ['activity' => $item])
                                @endif
                            @endforeach
                        @empty
                            <p>شما هنوز هیچ فعالیتی نداشته اید!</p>
                        @endforelse
                    </div>
                </div>

            </div>


    </div>
@endsection
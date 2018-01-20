@component('profiles.activities.activity')
    @slot('heading')
        {{ $user->name  }} publish a thread:
        <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent


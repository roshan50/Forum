<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <a href="#" class="flex">{{ $reply->owner->name }}</a> said
            {{ $reply->created_at->diffForHumans() }}

            <div>
                <form action="/replies/{{ $reply->id }}/favorites" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        Favorite {{ $reply->favorites->count() }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>
</div>
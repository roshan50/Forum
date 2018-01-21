<div id="reply-{{ $reply->id }}" class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <a href="/profiles/{{ $reply->owner->name }}" class="flex">{{ $reply->owner->name }}</a> said
            {{ $reply->created_at->diffForHumans() }}

            <div>
                <form action="/replies/{{ $reply->id }}/favorites" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        Favorite {{ $reply->favorites_count }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>

    @can('update',$reply)
        <div class="panel-footer level">
            <button class="btn btn-xs ml-1">ویرایش</button>
            <form action="/replies/{{ $reply->id }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger btn-xs" type="submit">حذف</button>
            </form>
        </div>
    @endcan
</div>
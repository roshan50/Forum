<reply :data="{{ $reply }}" inline-template v-cloak>
<div id="reply-{{ $reply->id }}" class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <a href="/profiles/{{ $reply->owner->name }}" class="flex">{{ $reply->owner->name }}</a> said
            {{ $reply->created_at->diffForHumans() }}

            <div>
                @if(Auth::check())
                    <favorite :reply="{{ $reply }}"></favorite>
                @endif
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div v-if="editing">
            <div class="form-group">
                <textarea name="" id="" class="form-control" v-model="attributes.body"></textarea>
            </div>
            <button class="btn btn-xs btn-primary" @click="update">ذخیره</button>
            <button class="btn btn-xs btn-link" @click="editing = false">لغو</button>
        </div>
        <div v-else v-text="attributes.body"></div>
    </div>

    @can('update',$reply)
        <div class="panel-footer level">
            <button class="btn btn-xs ml-1" @click="editing = true">ویرایش</button>
            <button class="btn btn-danger btn-xs" @click="destroy">حذف</button>
        </div>
    @endcan
</div>
</reply>
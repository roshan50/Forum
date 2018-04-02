@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <ais-index
                    app-id="{{ config('scout.algolia.id') }}"
                    api-key="{{ config('scout.algolia.key') }}"
                    index-name="threads"
                    query="{{ request('q') }}"
            >

                <div class="col-md-8">
                    <ais-results>
                        <template scope="{ result }">
                            <li>
                                <a :href="result.path">
                                    <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                </a>
                            </li>
                        </template>
                    </ais-results>
                </div>

                <div class="col-md-4">

                    @if(count($trending))
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                trending threads
                            </div>
                            <div class="panel-body">
                                <ul class="list-group">
                                    @foreach($trending as $thread)
                                        <li class="list-group-item">
                                            <a href="{{ url($thread->path) }}">
                                                {{ $thread->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                </div>
            </ais-index>
        </div>

    </div>
@endsection
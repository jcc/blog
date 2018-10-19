@extends('layouts.app')

@section('content')
    @component('particals.jumbotron')
        <h4>{{ lang('Discuss Problem') }}</h4>

        <h6>{{ lang('Discuss Subtitle') }}</h6>

        <a href="{{ url('discussion/create') }}" class="btn btn-info btn-sm"><i class="fas fa-pencil-alt"></i> {{ lang('Submit Problem') }}</a>
    @endcomponent

    <div class="discussion container mb-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                @forelse($discussions as $discussion)
                <div class="media my-3">
                    <div class="media-left mr-3">
                        <a href="{{ url('discussion', ['id' => $discussion->id]) }}">
                            <img class="media-object rounded-circle" width="50" src="{{ $discussion->user->avatar ?? config('blog.default_avatar') }}">
                        </a>
                    </div>
                    <div class="media-body">
                        <h5 class="media-heading">
                            <a href="{{ url('discussion', ['id' => $discussion->id]) }}">
                                {{ $discussion->title }}
                            </a>
                        </h5>
                        <div class="media-conversation-meta">
                            <div class="media-conversation-replies">
                                <a href="{{ url('discussion', ['id' => $discussion->id]) }}">
                                    {{ $discussion->comments->count() }}
                                </a>
                                {{ lang('Replies') }}
                            </div>
                        </div>
                        {{ $discussion->user->name ?? 'null' }}
                    </div>
                </div>
                @empty
                    <h3 class="text-center">{{ lang('Nothing') }}</h3>
                @endforelse
            </div>
        </div>
    </div>

    {{ $discussions->links('pagination.default') }}

@endsection

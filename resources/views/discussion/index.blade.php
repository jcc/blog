@extends('layouts.app')

@section('content')
    @component('particals.jumbotron')
        <h4>{{ lang('Discuss Problem') }}</h4>

        <h6>{{ lang('Discuss Subtitle') }}</h6>

        <a href="{{ url('discussion/create') }}" class="btn btn-info btn-sm"><i class="ion-edit"></i> {{ lang('Submit Problem') }}</a>
    @endcomponent

    <div class="discussion container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @forelse($discussions as $discussion)
                <div class="media">
                    <div class="media-left">
                        <a href="{{ url('discussion', ['id' => $discussion->id]) }}">
                            <img class="avatar media-object img-circle" src="{{ $discussion->user->avatar }}">
                        </a>
                    </div>
                    <div class="media-body">
                        <h6 class="media-heading">
                            <a href="{{ url('discussion', ['id' => $discussion->id]) }}">
                                {{ $discussion->title }}
                            </a>
                        </h6>
                        <div class="media-conversation-meta">
                            <div class="media-conversation-replies">
                                <a href="{{ url('discussion', ['id' => $discussion->id]) }}">
                                    {{ $discussion->comments->count() }}
                                </a>
                                {{ lang('Replies') }}
                            </div>
                        </div>
                        {{ $discussion->user->name or 'null' }}
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

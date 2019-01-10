@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h3>{{ $tag->tag }}</h3>

                    <h6>{{ lang('Tag Meta') }}</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ lang('For Articles') }} ( {{ $articles->count() }} )</div>
                    <ul class="list-group">
                        @forelse($articles as $article)
                            <li class="list-group-item">
                                <span class="badge">{{ $article->comments->count() }}</span>
                                <a href="{{ url($article->slug) }}">{{ $article->title }}</a>
                            </li>
                        @empty
                            <li class="nothing">{{ lang('Nothing') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ lang('For Discussions') }} ( {{ $discussions->count() }} )</div>
                    <ul class="list-group">
                        @forelse($discussions as $discussion)
                            <li class="list-group-item">
                                <span class="badge">{{ $discussion->comments->count() }}</span>
                                <a href="{{ url('discussion', ['id' => $discussion->id]) }}">{{ $discussion->title }}</a>
                            </li>
                        @empty
                            <li class="nothing">{{ lang('Nothing') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
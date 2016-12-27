@extends('layouts.app')

@section('content')
    <jumbotron v-cloak>
        <h3>{{ $category }}</h3>

        <h6>{{ lang('Category Meta') }}</h6>
    </jumbotron>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <ul class="list-group">
                    @forelse($articles as $article)
                        <li class="list-group-item">
                            <span class="badge">{{ $article->comments->count() }}</span>
                            <a href="{{ url($article->slug) }}">{{ $article->title }}</a>
                        </li>
                    @empty
                        <li class="list-group-item">{{ lang('Nothing') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
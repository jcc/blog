@extends('layouts.app')

@section('content')
    @component('particals.jumbotron')
        <h3>{{ $category->name }}</h3>

        <h6>{{ lang('Category Meta') }}</h6>
    @endcomponent

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <ul class="list-group">
                    @forelse($articles as $article)
                        <li class="list-group-item">
                            <span class="badge badge-secondary float-right">{{ $article->comments->count() }}</span>
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
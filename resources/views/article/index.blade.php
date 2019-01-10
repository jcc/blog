@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h3>{{ config('blog.article.title') }}</h3>

                    <h6>{{ config('blog.article.description') }}</h6>
                </div>
            </div>
        </div>
    </div>

    @include('widgets.article')

    {{ $articles->links('pagination.default') }}

@endsection
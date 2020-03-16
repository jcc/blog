@extends('layouts.app')
@section('header')
    @component('particals.jumbotron')
        <h1 class='oleo'>{{ $series->name }}</h1>

        <h3>{{ $series->description }}</h3>
    @endcomponent
@endsection
@section('content')

    @include('widgets.article')

    {{ $articles->links('pagination.default') }}

@endsection


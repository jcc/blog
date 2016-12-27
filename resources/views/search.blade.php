@extends('layouts.app')

@section('content')
    <jumbotron v-cloak>
        <h4>{{ request()->get('q') }}</h4>

        <h6>what you want to search.</h6>
    </jumbotron>

    @include('widgets.article')

@endsection
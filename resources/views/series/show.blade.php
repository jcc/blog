@extends('layouts.app')
@section('content')

@component('particals.jumbotron')
<h1>{{ $series->name }}</h1>

<h3>{{ $series->description }}</h3>
@endcomponent
@include('widgets.article')

{{ $articles->links('pagination.default') }}

@endsection
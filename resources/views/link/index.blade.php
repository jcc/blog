@extends('layouts.app')

@section('content')
    @component('particals.jumbotron')
        <h3>{{ lang('Links') }}</h3>
    @endcomponent

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <ul class="links text-center">
                    @forelse($links as $link)
                        <li><a href="{{ $link->link }}">{{ $link->name }}</a></li>
                    @empty
                        <li><h3>{{ lang('Nothing') }}</h3></li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection

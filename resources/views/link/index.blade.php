@extends('layouts.app')

@section('content')
    <jumbotron v-cloak>
        <h3>{{ lang('Links') }}</h3>
    </jumbotron>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
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

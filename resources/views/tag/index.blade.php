@extends('layouts.app')

@section('content')
    @component('particals.jumbotron')
        <h3>{{ lang('Tags') }}</h3>

        <h6>{{ lang('Tags Meta') }}</h6>
    @endcomponent

    <div class="container">
        <div class="row">
            @forelse($tags as $tag)
                <div class="col-md-3 text-center my-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5><a href="{{ url('tag', ['tag' => $tag->tag]) }}">{{ $tag->tag }}</a></h5>
                        </div>
                        <div class="card-body">
                            {{ $tag->meta_description }}
                        </div>
                    </div>
                </div>
            @empty
                <h3 class="text-center">{{ lang('Nothing') }}</h3>
            @endforelse
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="jumbotron text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h3>{{ lang('Tags') }}</h3>

                    <h6>{{ lang('Tags Meta') }}</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            @forelse($tags as $tag)
                <div class="col-md-3 text-center">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a href="{{ url('tag', ['tag' => $tag->tag]) }}">{{ $tag->tag }}</a>
                            </h3>
                        </div>
                        <div class="panel-body" style="font-size: 12px">
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

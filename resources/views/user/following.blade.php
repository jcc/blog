@extends('layouts.app')

@section('content')
    @include('user.particals.info')

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-default">
                    <div class="card-header">{{ lang('Your Followings') }} ( {{ $followings->count() }} )</div>
                    <ul class="list-group list-group-flush">
                        @forelse($followings as $following)
                            <li class="list-group-item">
                                <a href="{{ url('user', ['name' => $following->name]) }}">
                                    <img class="avatar img-circle" src="{{ $following->avatar }}">
                                    {{ $following->nickname ?? $following->name }}
                                </a>

                                @if($following->description)
                                <span class="description"> - {{ $following->description }}</span>
                                @endif
                            </li>
                        @empty
                            <li class="nothing">{{ lang('Nothing') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
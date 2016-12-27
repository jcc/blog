@extends('layouts.app')

@section('content')
    @include('user.particals.info')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ lang('Your Followings') }} ( {{ $followings->count() }} )</div>
                    <ul class="list-group">
                        @forelse($followings as $following)
                            <li class="list-group-item">
                                <a href="{{ url('user', ['name' => $following->name]) }}">
                                    <img class="avatar img-circle" src="{{ $following->avatar }}">
                                    {{ $following->nickname or $following->name }}
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
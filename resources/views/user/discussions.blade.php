@extends('layouts.app')

@section('content')
    @include('user.particals.info')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ lang('Your Discussions') }} ( {{ $discussions->count() }} )</div>

                    @include('user.particals.discussions')

                </div>
            </div>
        </div>
    </div>
@endsection
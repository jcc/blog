@extends('layouts.app')

@section('content')
    @include('user.particals.info')

    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-default">
                    <div class="card-header">{{ lang('Your Discussions') }} ( {{ $discussions->count() }} )</div>

                    @include('user.particals.discussions')

                </div>
            </div>
        </div>
    </div>
@endsection
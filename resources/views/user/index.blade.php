@extends('layouts.app')

@section('content')
    @include('user.particals.info')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ lang('Recent Discussions') }}</div>

                    @include('user.particals.discussions')

                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ lang('Recent Comments') }}</div>

                    @include('user.particals.comments')

                </div>
            </div>
        </div>
    </div>
@endsection
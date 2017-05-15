@extends('layouts.app')

@section('content')
    <div class="container notifications">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="tip">
                            <b>{{ Auth::user()->unreadNotifications->count() }}</b>
                            {{ lang('New Notification') }}
                        </span>
                        <a class="btn btn-success btn-sm pull-right mark-as-read" href="javascript:;"
                            onclick="event.preventDefault();document.getElementById('mark-as-read').submit();">
                            {{ lang('Mark As Read') }}
                        </a>
                        <form id="mark-as-read" action="{{ url('user/notification') }}" method="POST">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    <div class="panel-body">
                        <ul class="notification">
                            @foreach(Auth::user()->notifications as $notification)
                                @include('notifications.'. snake_case(class_basename($notification->type), '-'))
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
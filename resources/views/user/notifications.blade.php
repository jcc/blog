@extends('layouts.app')

@section('content')
    <div class="container notifications">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <span class="tip">
                            <b>{{ Auth::user()->unreadNotifications->count() }}</b>
                            {{ lang('New Notification') }}
                        </span>
                        <a class="btn btn-success btn-sm float-right mark-as-read" href="javascript:;"
                            onclick="event.preventDefault();document.getElementById('mark-as-read').submit();">
                            {{ lang('Mark As Read') }}
                        </a>
                        <form id="mark-as-read" action="{{ url('user/notification') }}" method="POST">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    <div class="card-body">
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
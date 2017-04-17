@extends('layouts.app')

@section('content')
    <div class="container setting">
        <div class="row">
            <div class="col-md-4">
                @include('setting.particals.sidebar')
            </div>

            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-heading">
                    <span>{{ Auth::user()->unreadNotifications->count() }}</span>
                    {{ lang('New Notification') }}
        <a class="pull-right mark-as-read" href="#"
           onclick="event.preventDefault();
                                                     document.getElementById('mark-as-read').submit();">
            {{ lang('Mark As Read') }}
        </a>

        <form id="mark-as-read" action="{{ url('user/notification') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
                    </div>

                    <div class="panel-body">
                        <div class="row notification">
                            @foreach(Auth::user()->notifications as $notification)
                                @include('user.notice.'. snake_case(class_basename($notification->type), '-'))
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
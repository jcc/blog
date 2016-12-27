@extends('layouts.app')

@section('content')
    <div class="container setting">
        <div class="row">
            <div class="col-md-4">
                @include('setting.particals.sidebar')
            </div>

            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-heading">{{ lang('Notification Setting') }}</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ url('setting/notification') }}" method="POST">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-md-4 control-label text-right">{{ lang('Email Notification') }}</label>
                                <div class="col-md-6">
                                    <div class="togglebutton" style="margin-top: 6px">
                                        <label>
                                            <input type="checkbox" name="email_notify_enabled" {{ Auth::user()->email_notify_enabled == 'yes' ? 'checked' : '' }}>
                                            <span class="toggle"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-10 text-right" style="margin-top: 30px;">
                                    <button type="submit" class="btn btn-success">{{ lang('Submit') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
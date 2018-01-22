@extends('layouts.app')

@section('content')
    <div class="container setting">
        <div class="row">
            <div class="col-md-4">
                @include('setting.particals.sidebar')
            </div>

            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">{{ lang('Notification Setting') }}</div>

                    <div class="card-body">
                        <form class="form-horizontal" action="{{ url('setting/notification') }}" method="POST">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-right">{{ lang('Email Notification') }}</label>
                                <div class="col-md-6">
                                    <div class="togglebutton mt-2">
                                        <label>
                                            <input type="checkbox" name="email_notify_enabled" {{ Auth::user()->email_notify_enabled == 'yes' ? 'checked' : '' }}>
                                            <span class="toggle"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4 mt-3">
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
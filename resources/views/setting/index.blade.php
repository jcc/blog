@extends('layouts.app')

@section('content')
    <div class="container setting">
        <div class="row">
            <div class="col-md-4">
                @include('setting.particals.sidebar')
            </div>

            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-heading">{{ lang('Reset Password') }}</div>

                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ url('password/change') }}" method="POST">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label text-right">{{ lang('Old Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="old_password" required>

                                    @if ($errors->has('old_password'))
                                        <span class="help-block">
                                            <strong>{{ trans($errors->first('old_password')) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label text-right">{{ lang('New Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ trans($errors->first('password')) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label text-right">{{ lang('Confirm New Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ trans($errors->first('password_confirmation')) }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button style="submit" class="btn btn-primary">{{ lang('Update Password') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
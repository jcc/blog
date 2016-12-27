@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">
            <div class="well bs-component">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('auth/github/register') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="github_id" value="{{ $oauthData['github_id'] }}">
                    <fieldset>
                        <legend class="text-center">{{ lang('Register') }}</legend>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <label for="name" class="control-label">{{ lang('Username') }}</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ $oauthData['github_name'] or '' }}" placeholder="{{ lang('Input Name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <label for="email" class="control-label">{{ lang('Email') }}</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ $oauthData['email'] or '' }}" placeholder="{{ lang('Input Email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <label for="password" class="control-label">{{ lang('Password') }}</label>
                                <input id="password" type="password" class="form-control" name="password" placeholder="{{ lang('Input Password') }}" required autofocus>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <label for="password-confirm" class="control-label">{{ lang('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ lang('Input Confirm Password') }}" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-1">
                                <button type="submit" class="btn btn-primary form-control">
                                    {{ lang('Register') }}
                                </button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
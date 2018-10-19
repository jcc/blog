@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3" style="margin-top: 50px;">
            <div class="well">
                <form class="form" role="form" method="POST" action="{{ url('auth/github/register') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="github_id" value="{{ $oauthData['github_id'] }}">
                    <fieldset>
                        <legend class="text-center">{{ lang('Register') }}</legend>

                        <div class="form-group">
                            <div class="col-md-10 offset-md-1">
                                <label for="name" class="control-label">{{ lang('Username') }}</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $oauthData['github_name'] ?? '' }}" placeholder="{{ lang('Input Name') }}" required>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 offset-md-1">
                                <label for="email" class="control-label">{{ lang('Email') }}</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $oauthData['email'] ?? '' }}" placeholder="{{ lang('Input Email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 offset-md-1">
                                <label for="password" class="control-label">{{ lang('Password') }}</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ lang('Input Password') }}" required autofocus>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 offset-md-1">
                                <label for="password-confirm" class="control-label">{{ lang('Confirm Password') }}</label>

                                <input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="{{ lang('Input Confirm Password') }}" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-10 offset-md-1">
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
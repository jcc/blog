@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="margin-top: 50px;">
            <div class="well bs-component">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <fieldset>
                        <legend class="text-center">{{ lang('Login') }}</legend>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <label class="control-label" for="email">{{ lang('Email') }}</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ lang('Input Email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-md-10 col-md-offset-1">
                                <label class="control-label" for="password">{{ lang('Password') }}</label>
                                <input id="password" type="password" class="form-control" name="password" placeholder="{{ lang('Input Password') }}" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-1">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> {{ lang('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-1">
                                <button type="submit" class="btn btn-success form-control">
                                    {{ lang('Login') }}
                                </button>
                            </div>
                        </div>

                        @if(config('services.github.client_id'))
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                            <div class="strike">
                                <span>or</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-1">
                                <a href="{{ url('/auth/github') }}" class="btn btn-primary form-control">
                                    <i class="ion-social-github"></i> {{ lang('Login With Github') }}
                                </a>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2 text-center">
                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    {{ lang('Forgot Password') }}
                                </a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

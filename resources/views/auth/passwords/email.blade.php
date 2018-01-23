@extends('layouts.app')

<!-- Main Content -->
@section('content')
<div class="container" style="margin-top: 40px;">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-info">
                <div class="card-header">{{ lang('Reset Password') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label">{{ lang('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ lang('Reset Password Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

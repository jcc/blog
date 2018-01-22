@extends('layouts.app')

@section('content')
<div class="container profile">
    <div class="row">
        <div class="col-md-2 offset-md-1">
            <avatar src="{{ $user->avatar }}"></avatar>
        </div>
        <div class="col-md-7">
            <form action="{{ url('user/profile', ['id' => $user->id]) }}" method="POST" class="form">
                {{ method_field('PUT') }}
                {{ csrf_field() }}

                <fieldset>
                    <div class="form-group row">
                        <label for="Name" class="col-md-3 col-form-label">{{ lang('Username') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Name" value="{{ $user->name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Email" class="col-md-3 col-form-label">{{ lang('Email') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Email" value="{{ $user->email }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Nickname" class="col-md-3 col-form-label">{{ lang('Nickname') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Nickname" name="nickname" value="{{ $user->nickname }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Website" class="col-md-3 col-form-label">{{ lang('Website') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Website" name="website" value="{{ $user->website }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Weibo" class="col-md-3 col-form-label">{{ lang('Weibo Name') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Weibo" name="weibo_name" value="{{ $user->weibo_name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Weibo" class="col-md-3 col-form-label">{{ lang('Weibo Home') }}</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Weibo" name="weibo_link" value="{{ $user->weibo_link }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="GitHub" class="col-md-3 col-form-label">GitHub</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="GitHub" name="github" value="{{ $user->github_name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Description" class="col-md-3 col-form-label">{{ lang('Description') }}</label>
                        <div class="col-md-9">
                            <textarea class="form-control" rows="3" name="description" id="Description">{{ $user->description }}</textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-action row">
                        <div class="offset-md-3 col-md-9">
                            <button class="btn btn-success btn-block" type="submit">{{ lang('Update Profile') }}</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
@endsection

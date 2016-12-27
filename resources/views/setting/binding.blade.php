@extends('layouts.app')

@section('content')
    <div class="container setting">
        <div class="row">
            <div class="col-md-4">
                @include('setting.particals.sidebar')
            </div>

            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-heading">{{ lang('Account Binding') }}</div>

                    <div class="panel-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label text-right">{{ lang('Binding Github') }}</label>
                                <div class="col-md-6">
                                    @if(!Auth::user()->github_id && config('services.github.client_id'))
                                        <a href="{{ url('auth/github') }}" class="btn btn-default">
                                            <i class="ion-social-github"></i> Github
                                        </a>
                                    @else
                                        <button class="btn btn-default" disabled>
                                            <i class="ion-social-github"></i> Github
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="container setting">
        <div class="row">
            <div class="col-md-4">
                @include('setting.particals.sidebar')
            </div>

            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">{{ lang('Account Binding') }}</div>

                    <div class="card-body">
                        <form class="form">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-right">{{ lang('Binding Github') }}</label>
                                <div class="col-md-6">
                                    @if(!Auth::user()->github_id && config('services.github.client_id'))
                                        <a href="{{ url('auth/github') }}" class="btn btn-light">
                                            <i class="fab fa-github"></i> Github
                                        </a>
                                    @else
                                        <button class="btn btn-light" disabled>
                                            <i class="fab fa-github"></i> Github
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
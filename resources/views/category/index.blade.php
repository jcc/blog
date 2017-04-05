@extends('layouts.app')

@section('content')
    @component('particals.jumbotron')
        <h3>{{ lang('Categories') }}</h3>

        <h6>{{ lang('Categories Meta') }}</h6>
    @endcomponent

    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <ul class="list-group">
                    @forelse($categories as $category)
                        <li class="list-group-item">
                            <span class="badge">{{ $category->articles->count() }}</span>
                            <a href="{{ url('category', ['name' => $category->name]) }}">{{ $category->name }}</a>
                        </li>
                    @empty
                        <li class="list-group-item">{{ lang('Nothing') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection
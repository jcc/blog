@extends('layouts.app')
@section('content')

@component('particals.jumbotron')
<h1>{{ config('blog.article.title') }}</h1>

<h3>{{ config('blog.article.description') }}</h3>
@endcomponent
<div class="container list">
	<div class="row">
		<ul class="list-unstyled col-md-10 offset-md-1">
			@forelse($seriess as $series)
			<li class="media">
				<div class="media-body">
					<h2 class="media-heading">
						<a href="series/{{$series->id}}">
							{{ $series->name }}
						</a>
						<div class="meta">
							<h5>{{ $series->description }}</h5>
						</div>
					</h2>
					<div class="extra">
						<div class="info">
							<i class="fab fa-buffer"></i>{{ sizeof($series->articles) }}
							<i class="fas fa-eye"></i>{{ $series->articles()->sum('view_count') }}
						</div>
					</div>
				</div>
			</li>
			@empty
			<h3 class="text-center">{{ lang('Nothing') }}</h3>
			@endforelse
		</ul>
	</div>
</div>


@endsection
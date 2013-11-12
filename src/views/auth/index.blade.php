@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ Lang::get('lingos::general.dashboard') }}
@stop

@section('title')
	<i class="fa fa-dashboard fa-lg"></i>
	{{ Lang::get('lingos::general.dashboard') }}
@stop

@section('content')


<p class="lead">
	@if (Sentry::check())
		{{ Lang::get('lingos::auth.logged_in') }}
	@else
		{{ Lang::get('lingos::auth.logged_out') }}
	@endif
</p>


@stop

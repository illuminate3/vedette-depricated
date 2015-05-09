@extends(Config::get('vedette::vedette_views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ trans('lingos::general.dashboard') }}
@stop

@section('title')
	<i class="fa fa-dashboard fa-lg"></i>
	{{ trans('lingos::general.dashboard') }}
@stop

@section('content')


<p class="lead">
	@if (Sentry::check())
		{{ trans('lingos::auth.logged_in') }}
	@else
		{{ trans('lingos::auth.logged_out') }}
	@endif
</p>


@stop

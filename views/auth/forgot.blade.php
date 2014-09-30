@extends(Config::get('vedette.vedette_views.layout_simple'))

@section('title')
@parent
	{{  Config::get('vedette.vedette_config.separator') }}
	{{ trans('lingos::auth.forgot_password') }}
@stop

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('packages/illuminate3/vedette/assets/css/login.css') }}">
@stop

@section('scripts')
@stop

@section('inline-scripts')
$(document).ready(function() {

});
@stop

@section('content')
<div class="row centered">
<div class="col-xs-12 col-sm-8 col-sm-offset-1 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">

{{ Form::open(
	[
		'route' => 'password.request',
		'role' => 'form',
		'class' => 'well'
	]
) }}

	<h2>
		{{ trans('lingos::auth.forgot_password') }}
	</h2>

	<hr>

	{{ $message = Session::get('message') }}

	{{ Bootstrap::email(
		'email',
		null,
		null,
		$errors,
		'envelope fa-fw',
		[
			'id' => 'email',
			'placeholder' => trans('lingos::account.email'),
			'required',
			'autocomplete' => 'off',
			'autofocus'
		]
	) }}

	{{ Bootstrap::submit(
		trans('lingos::button.send'),
		[
			'class' => 'btn btn-success btn-block'
		]
	) }}

	<hr>

	<div class="text-center">
	{{ Bootstrap::linkIcon(
		'login',
		trans('lingos::button.cancel'),
		'times fa-fw',
		[
			'class' => 'btn btn-default'
		]
	) }}

	{{ Bootstrap::linkIcon(
		'register',
		trans('lingos::button.register'),
		'plus fa-fw',
		[
			'class' => 'btn btn-default'
		]
	) }}
	</div>

{{ Form::close() }}

</div>
</div>
@stop

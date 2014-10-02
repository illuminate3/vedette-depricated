@extends(Config::get('vedette.vedette_views.layout_simple'))

@section('title')
@parent
	{{ Config::get('vedette.vedette_html.separator') }}
	{{ trans('lingos::auth.register') }}
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
<div class="row">
<div class="col-xs-12 col-sm-8 col-sm-offset-1 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">

{{ Form::open(
	[
		'route' => 'auth.store',
		'role' => 'form',
		'class' => 'well'
	]
) }}

	<h2>
		{{ trans('lingos::auth.register') }}
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

	{{ Bootstrap::password(
		'password',
		null,
		$errors,
		'unlock fa-fw',
		[
			'id' => 'password',
			'placeholder' => trans('lingos::auth.password'),
			'required',
			'autocomplete' => 'off'
		]
	) }}

	{{ Bootstrap::password(
		'password_confirmation',
		null,
		$errors,
		'unlock-alt fa-fw',
		[
			'id' => 'password',
			'placeholder' => trans('lingos::auth.confirm_password'),
			'required',
			'autocomplete' => 'off'
		]
	) }}

	{{ Bootstrap::submit(
		trans('lingos::button.register'),
		[
			'class' => 'btn btn-success btn-block'
		]
	) }}

	<hr>

	<div class="row">
		<div class="col-sm-6">
		{{ Bootstrap::linkIcon(
			'login',
			trans('lingos::button.cancel'),
			'times fa-fw',
			[
				'class' => 'btn btn-default btn-block'
			]
		) }}
		</div>
		<div class="col-sm-6">
		{{ Bootstrap::linkIcon(
			'forgot',
			trans('lingos::button.forgot_password'),
			'external-link fa-fw',
			[
				'class' => 'btn btn-default btn-block'
			]
		) }}
		</div>
	</div>

{{ Form::close() }}

</div>
</div>
@stop

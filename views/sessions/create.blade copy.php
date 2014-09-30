@extends(Config::get('vedette.vedette_views.layout-login'))

@section('title')
@parent
	{{  Config::get('vedette.vedette_config.separator') }}
	{{ trans('lingos::auth.log_in') }}
@stop

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('packages/illuminate3/vedette/assets/vendors/backstretch/css/backstretch.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('packages/illuminate3/vedette/assets/css/login.css') }}">
@stop

@section('scripts')
	<script src="{{ URL::asset('packages/illuminate3/vedette/assets/vendors/backstretch/jquery.backstretch.min.js') }}"></script>
	<script src="{{ URL::asset('packages/illuminate3/vedette/assets/vendors/nnattawat-flip/jquery.flip.js') }}"></script>
	<script src="{{ URL::asset('packages/illuminate3/vedette/assets/js/login.js') }}"></script>
@stop

@section('inline-scripts')
$(document).ready(function() {

	$.backstretch([
	  "{{ Config::get('vedette.vedette_settings.image_1') }}",
	  "{{ Config::get('vedette.vedette_settings.image_2') }}",
	], { duration: 3000, fade: 750 });

});
@stop

@section('content')
<div class="row">
<div class="col-xs-12 col-sm-8 col-sm-offset-1 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">

<div class="panelBox">
{{ Form::open(
	[
		'route' => 'sessions.store',
		'role' => 'form'
	]
) }}

<div class="front">
	<div class="pull-right clearfix">
		<i class="fa fa-info-circle fa-lg flipLink" id="flipToBack"></i>
	</div>

	<h2>
		{{ trans('lingos::auth.sign_on') }}
	</h2>

	<hr>

	{{ Bootstrap::linkIcon(
		'oauth',
		trans('lingos::button.sign_on'),
		'fa-google fa-lg',
		[
			'class' => 'btn btn-success btn-block'
		]
	) }}

</div><!-- front -->
<div class="back">

	<div class="pull-right clearfix">
		<i class="fa fa-google fa-lg flipLink" id="flipToFront"></i>
	</div>

	<h2>
		{{ trans('lingos::auth.log_in') }}
	</h2>

	<hr>

	{{ Bootstrap::email(
		'email',
		null,
		null,
		$errors,
		'fa-envelope fa-fw',
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
		'fa-key fa-fw',
		[
			'id' => 'password',
			'placeholder' => trans('lingos::auth.password'),
			'required',
			'autocomplete' => 'off'
		]
	) }}

	{{ Bootstrap::checkbox(
		'remember_me',
		 trans('lingos::auth.remember_me_pc')
	) }}

	{{ Bootstrap::submit(
		trans('lingos::button.log_in'),
		[
			'class' => 'btn btn-success btn-block'
		]
	) }}

	<hr>

	<div class="text-center">
	{{ Bootstrap::linkIcon(
		'register',
		trans('lingos::button.register'),
		'fa-plus-circle fa-fw',
		[
			'class' => 'btn btn-info'
		]
	) }}

	{{ Bootstrap::linkIcon(
		'password.remind',
		trans('lingos::button.forgot_password'),
		'fa-external-link fa-fw',
		[
			'class' => 'btn btn-primary'
		]
	) }}
	</div>

	<hr>

	{{ Bootstrap::linkIcon(
		'oauth',
		trans('lingos::button.sign_on'),
		'fa-google fa-lg',
		[
			'class' => 'btn btn-default btn-block'
		]
	) }}

</div><!-- back -->

{{ Form::close() }}
</div>
</div>
</div>
@stop

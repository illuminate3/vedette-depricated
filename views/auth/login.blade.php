@extends(Config::get('vedette.vedette_views.layout_simple'))

@section('title')
@parent
	{{ Config::get('vedette.vedette_html.separator') }}
	{{ trans('lingos::auth.log_in') }}
@stop

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('packages/illuminate3/vedette/assets/vendors/backstretch/css/backstretch.css') }}">
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
<div class="row centered">
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
		'o-auth/login',
		trans('lingos::button.sign_on'),
		'google fa-lg',
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
		'key fa-fw',
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

	<div class="row">
		<div class="col-sm-6">
		{{ Bootstrap::linkIcon(
			'register',
			trans('lingos::button.register'),
			'plus fa-fw',
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

	<hr>

	{{ Bootstrap::linkIcon(
		'o-auth/login',
		trans('lingos::button.sign_on'),
		'google fa-lg',
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

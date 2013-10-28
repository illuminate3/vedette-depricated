@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('page_title')
	- {{ Lang::get('lingos::auth.sign_in') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-sign-in fa-lg"></i>
		{{ Lang::get('lingos::auth.sign_in') }}
	</h1>
@stop

@section('content')
	<div class="margin-top-20">
		@if ( Session::has('login_error') )
			<div class="alert alert-danger">
				<strong>{{ Session::get('login_error') }}</strong>
			</div>
		@endif
	</div>

	<div class="row">
		<form action="{{ URL::route('admin.login') }}" class="form-signin" method="POST">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<div class="input-group margin-bottom-sm">
			  <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
			  <input class="form-control" type="text" placeholder="{{ Lang::get('lingos::general.email') }}" name="login_attribute" id="login_attribute" value="{{ Input::old('login_attribute') }}" autofocus>
			</div>

			<div class="input-group">
			  <span class="input-group-addon"><i class="fa fa-key"></i></span>
				<input class="form-control" type="password" name="password" id="password" placeholder="{{ Lang::get('lingos::auth.password') }}">
			</div>

			<label class="checkbox">
				<input type="checkbox"name="remember_me" value="true">{{ Lang::get('lingos::auth.remember_me') }}
			</label>

			<button type="submit" class="btn btn-success"><i class="fa fa-check-circle-o"></i>{{ Lang::get('lingos::button.sign_in') }}</button>

			<hr>

			<div class="margin-top">
				<a class="btn btn-danger" href="{{ URL::route('home') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
				<a class="btn btn-info" href="{{ URL::route('signup') }}"><i class="fa fa-plus-circle"></i>{{ Lang::get('lingos::button.register') }}</a>
					<!--
						TODO: make link to forget password
					-->
				<a class="btn btn-warning" href="{{ URL::route('forgot-password') }}"><i class="fa fa-external-link"></i>{{ Lang::get('lingos::button.forgot_password') }}</a>
			</div>

			<div class="margin-top">
			</div>

		</form>

	</div>
@stop

@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ Lang::get('lingos::auth.sign_in') }}
@stop

@section('title')
	<i class="fa fa-sign-in fa-lg"></i>
	{{ Lang::get('lingos::auth.sign_in') }}
@stop

@section('content')

	{{ Former::horizontal_open()
		->id('form-forgot')
		->secure()
		->rules(['email' => 'required'])
	}}

	<fieldset>
		{{ Former::text('email', '')
			->prepend('<i class="fa fa-envelope-o"></i>')
			->class('form-control has-error')
			->id('email')
			->placeholder(Lang::get('lingos::general.email'))
			->value(Input::old('email'))
			->autofocus()
		}}
		{{ Former::password('password', '')
			->prepend('<i class="fa fa-unlock-o"></i>')
			->class('form-control has-error')
			->id('password')
			->value(Input::old('password'))
			->placeholder(Lang::get('lingos::auth.password'))
		}}
		<div class="checkbox">
			<label>
				<input type="checkbox"name="remember-me" value="true">{{ Lang::get('lingos::auth.remember_me') }}
			</label>
		</div>
	</fieldset>

	<br>

	<div class="row btn-toolbar" role="toolbar">
		<div class="col-xs-6 col-md-4">
			<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ Lang::get('lingos::button.sign_in') }}">
			<div>
				<br>
			</div>
			<a class="btn btn-warning" href="{{ URL::route('home') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
			<a class="btn btn-primary" href="{{ URL::route('signup') }}"><i class="fa fa-plus-circle"></i>{{ Lang::get('lingos::button.register') }}</a>
			<a class="btn btn-info" href="{{ URL::route('forgot-password') }}"><i class="fa fa-external-link"></i>{{ Lang::get('lingos::button.forgot_password') }}</a>
		</div>
	</div>

{{ Former::close() }}

@stop

@extends(Config::get('vedette::vedette_views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ trans('lingos::auth.sign_in') }}
@stop

@section('title')
	<i class="fa fa-sign-in fa-lg"></i>
	{{ trans('lingos::auth.sign_in') }}
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
			->placeholder(trans('lingos::general.email'))
			->value(Input::old('email'))
			->autofocus()
		}}
		{{ Former::password('password', '')
			->prepend('<i class="fa fa-unlock-o"></i>')
			->class('form-control has-error')
			->id('password')
			->value(Input::old('password'))
			->placeholder(trans('lingos::auth.password'))
		}}
		<div class="checkbox">
			<label>
				<input type="checkbox"name="remember_me" id="remember_me" value="true">{{ trans('lingos::auth.remember_me') }}
			</label>
		</div>
	</fieldset>

	<br>

	<div class="row btn-toolbar" role="toolbar">
		<div class="col-xs-6 col-md-4">
			<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ trans('lingos::button.sign_in') }}">
			<div>
				<br>
			</div>
			<a class="btn btn-warning" href="{{ route('vedette.home') }}"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
			<a class="btn btn-primary" href="{{ route('vedette.register') }}"><i class="fa fa-plus-circle"></i>{{ trans('lingos::button.register') }}</a>
			<a class="btn btn-info" href="{{ route('vedette.forgot-password') }}"><i class="fa fa-external-link"></i>{{ trans('lingos::button.forgot_password') }}</a>
		</div>
	</div>

{{ Former::close() }}

@stop

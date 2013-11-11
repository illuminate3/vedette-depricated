@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ Lang::get('lingos::auth.forgot_password') }}
@stop

@section('title')
	<i class="fa fa-external-link fa-lg"></i>
	{{ Lang::get('lingos::auth.forgot_password') }}
@stop

@section('content')

	{{ Former::horizontal_open()
		->rules(['confirm_password' => 'required'])
		->secure()
	}}

	<fieldset>
		<legend><i class="fa fa-key"></i>{{ Lang::get('lingos::auth.new_password') }}</legend>
		{{ Former::password('password', '')
			->prepend('<i class="fa fa-unlock-o"></i>')
			->class('form-control has-error')
			->id('password')
			->value(Input::old('password'))
			->placeholder(Lang::get('lingos::auth.password'))
		}}
		{{ Former::password('confirm_password', '')
			->prepend('<i class="fa fa-unlock"></i>')
			->class('form-control has-error')
			->id('password_confirmation')
			->value(Input::old('confirm_password'))
			->placeholder(Lang::get('lingos::auth.confirm_password'))
		}}
	</fieldset>

	<br>

	<div class="row btn-toolbar" role="toolbar">
		<div class="col-xs-6 col-md-4">
			<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ Lang::get('lingos::button.submit') }}">
			<div>
				<br>
			</div>
			<input class="btn-inverse btn" type="reset" value="{{ Lang::get('lingos::button.reset') }}">
			<a class="btn btn-warning" href="{{ URL::route('home') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
		</div>
	</div>

	{{ Former::close() }}

@stop

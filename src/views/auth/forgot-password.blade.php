@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('page_title')
	- {{ Lang::get('lingos::auth.forgot_password') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-external-link fa-lg"></i>
		{{ Lang::get('lingos::auth.forgot_password') }}
	</h1>
@stop

@section('content')

	{{ Former::horizontal_open()
		->id('form-forgot')
		->secure()
		->rules(['email' => 'required'])
	}}

		{{ Former::text('email', '')
			->prepend('<i class="fa fa-envelope-o"></i>')
			->class('form-control has-error')
			->id('email')
			->placeholder(Lang::get('lingos::general.email'))
		}}

		<div class="margin-top">
			{{ Former::actions()
				->success_submit(Lang::get('lingos::button.send'))
				->inverse_reset(Lang::get('lingos::button.reset'))
			}}
		</div>

		<hr>

		<div class="margin-top">
			<a class="btn btn-danger" href="{{ URL::route('home') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
		</div>

	{{ Former::close() }}

@stop

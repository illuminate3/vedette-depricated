@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('page_title')
	- {{ Lang::get('lingos::auth.register') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-pencil-square-o fa-lg"></i>
		{{ Lang::get('lingos::auth.register') }}
	</h1>
@stop

@section('content')

			{{ Former::horizontal_open(route('admin.register')) }}

				<fieldset>
					<legend><i class="fa fa-user"></i>{{ Lang::get('vedette::vedette.personal_information') }}</legend>
					{{ Former::text('first_name', '')
						->prepend('<i class="fa fa-check-circle"></i>')
						->class('form-control has-error')
						->id('first_name')
						->placeholder(Lang::get('lingos::general.first_name'))
						->autofocus()
					}}
					{{ Former::text('last_name', '')
						->prepend('<i class="fa fa-check-circle-o"></i>')
						->class('form-control has-error')
						->id('last_name')
						->placeholder(Lang::get('lingos::general.last_name'))
					}}
				</fieldset>

				<br>

				<fieldset>
					<legend><i class="fa fa-envelope-o"></i>{{ Lang::get('lingos::general.email') }}</legend>
					{{ Former::text('email', '')
						->prepend('<i class="fa fa-envelope-o"></i>')
						->class('form-control has-error')
						->id('email')
						->placeholder(Lang::get('lingos::general.email'))
					}}
				</fieldset>

				<br>

				<fieldset>
					<legend><i class="fa fa-key"></i>{{ Lang::get('lingos::auth.password') }}</legend>
					{{ Former::password('password', '')
						->prepend('<i class="fa fa-unlock-o"></i>')
						->class('form-control has-error')
						->id('password')
						->placeholder(Lang::get('lingos::auth.password'))
					}}
					{{ Former::password('confirm_password', '')
						->prepend('<i class="fa fa-unlock"></i>')
						->class('form-control has-error')
						->id('confirm_password')
						->placeholder(Lang::get('lingos::auth.confirm_password'))
					}}
				</fieldset>

				<hr>

				<div class="margin-top">
					{{ Former::actions()
						->success_submit(Lang::get('lingos::button.register'))
						->inverse_reset(Lang::get('lingos::button.reset'))
					}}
				</div>

				<div class="margin-top">
					<a class="btn btn-danger" href="{{ URL::route('home') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
				</div>

			{{ Former::close() }}

@stop

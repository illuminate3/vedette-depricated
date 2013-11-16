@extends(Config::get('vedette::vedette_views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ trans('lingos::sentry.user_command.new') }}
@stop

@section('title')
	<i class="fa fa-pencil-square-o fa-lg"></i>
	{{ trans('lingos::sentry.user_command.new') }}
@stop

@section('content')
@if (Sentry::check())

	<div class="row">
	<div class="row btn-toolbar pull-right" role="toolbar">
		<a href="{{ route('auth.users.index') }}" class="btn btn-info" title="{{ trans('lingos::button.back') }}">
			<i class="fa fa-backward"></i>
			{{ trans('lingos::button.back') }}
		</a>
	</div>
	</div>

	<div class="row">
	{{ Former::horizontal_open( route('auth.users.store') ) }}

	<fieldset>
		<legend><i class="fa fa-user"></i>{{ trans('lingos::general.personal_information') }}</legend>
		{{ Former::text('first_name', '')
			->prepend('<i class="fa fa-check-circle"></i>')
			->class('form-control has-error')
			->id('first_name')
			->placeholder(trans('lingos::general.first_name'))
			->autofocus()
		}}
		{{ Former::text('last_name', '')
			->prepend('<i class="fa fa-check-circle-o"></i>')
			->class('form-control has-error')
			->id('last_name')
			->placeholder(trans('lingos::general.last_name'))
		}}
	</fieldset>

	<br>

	<fieldset>
		<legend><i class="fa fa-envelope-o"></i>{{ trans('lingos::general.email') }}</legend>
		{{ Former::text('email', '')
			->prepend('<i class="fa fa-envelope-o"></i>')
			->class('form-control has-error')
			->id('email')
			->placeholder(trans('lingos::general.email'))
		}}
	</fieldset>

	<br>

	<fieldset>
		<legend><i class="fa fa-key"></i>{{ trans('lingos::auth.password') }}</legend>
		{{ Former::password('password', '')
			->prepend('<i class="fa fa-unlock-o"></i>')
			->class('form-control has-error')
			->id('password')
			->placeholder(trans('lingos::auth.password'))
		}}
		{{ Former::password('password_confirmation', '')
			->prepend('<i class="fa fa-unlock"></i>')
			->class('form-control has-error')
			->id('confirm_password')
			->placeholder(trans('lingos::auth.confirm_password'))
		}}
	</fieldset>

	<hr>

	<div class="row btn-toolbar" role="toolbar">
		<div class="col-xs-6 col-md-4">
			<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ trans('lingos::button.register') }}">
			<div>
				<br>
			</div>
			<input class="btn-inverse btn" type="reset" value="{{ trans('lingos::button.reset') }}">
			<a class="btn btn-warning" href="{{ route('auth.users.index') }}"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
		</div>
	</div>

	{{ Former::close() }}
	</div>

@else
	<div class="alert alert-warning">
		<h2>
			{{ trans('lingos::sentry.permission_error.insufficient') }}
		</h2>
	</div>
@endif
@stop

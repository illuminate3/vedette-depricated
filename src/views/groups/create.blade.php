@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ Lang::get('lingos::sentry.group_command.create') }}
@stop

@section('title')
	<i class="fa fa-umbrella fa-lg"></i>
	{{ Lang::get('lingos::sentry.group_command.create') }}
@stop

@section('content')
@if (Sentry::check())

	<div class="row">
	<div class="row btn-toolbar pull-right" role="toolbar">
		<a href="{{ route('auth.groups.index') }}" class="btn btn-info" title="{{ Lang::get('lingos::button.back') }}">
			<i class="fa fa-backward"></i>
			{{ Lang::get('lingos::button.back') }}
		</a>
	</div>
	</div>

	<br>

	<div class="row">
	{{ Former::horizontal_open( route('auth.groups.store') ) }}

		{{ Former::text('name', '')
			->prepend('<i class="fa fa-umbrella"></i>')
			->class('form-control has-error')
			->id('name')
			->placeholder(Lang::get('lingos::sentry.group_command.create'))
			->autofocus()
		}}

		<hr>

		<div class="row btn-toolbar" role="toolbar">
			<div class="col-xs-6 col-md-4">
				<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ Lang::get('lingos::button.create') }}">
				<div>
					<br>
				</div>
				<input class="btn-inverse btn" type="reset" value="{{ Lang::get('lingos::button.reset') }}">
				<a class="btn btn-warning" href="{{ route('auth.groups.index') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
			</div>
		</div>

	{{ Former::close() }}
	</div>

@else
	<div class="alert alert-warning">
		<h2>
			{{ Lang::get('lingos::sentry.permission_error.insufficient') }}
		</h2>
	</div>
@endif
@stop

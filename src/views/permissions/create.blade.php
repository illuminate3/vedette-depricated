@extends(Config::get('vedette::vedette_views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ trans('lingos::sentry.permission_command.create') }}
@stop

@section('title')
	<i class="fa fa-pencil-square-o fa-lg"></i>
	{{ trans('lingos::sentry.permission_command.create') }}
@stop

@section('content')
@if (Sentry::check())

	<div class="row">
	<div class="row btn-toolbar pull-right" role="toolbar">
		<a href="{{ route('auth.permissions.index') }}" class="btn btn-info" title="{{ trans('lingos::button.back') }}">
			<i class="fa fa-backward"></i>
			{{ trans('lingos::button.back') }}
		</a>
	</div>
	</div>

	<br>

	<div class="row">
	{{ Former::horizontal_open( route('auth.permissions.store') ) }}

	{{ Former::text('name', '')
		->prepend('<i class="fa fa-building"></i>')
		->class('form-control has-error')
		->id('name')
		->placeholder(trans('lingos::sentry.module'))
		->autofocus()
	}}

	<br>

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">{{ trans('lingos::sentry.generic_permissions') }}</h3>
		</div>
		<div class="panel-body">
			<div class="padding-left">
				{{ Former::checkboxes('permissions')
					->checkboxes($roles['inputs'])
					->label('')
					->class('padding-left')
				}}
			</div>
		</div>
	</div>

	<hr>

	<div class="row btn-toolbar" role="toolbar">
		<div class="col-xs-6 col-md-4">
			<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ trans('lingos::button.create') }}">
			<div>
				<br>
			</div>
			<input class="btn-inverse btn" type="reset" value="{{ trans('lingos::button.reset') }}">
			<a class="btn btn-warning" href="{{ URL::route('auth.permissions.index') }}"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
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

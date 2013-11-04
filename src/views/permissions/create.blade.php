@extends(Config::get('vedette::views.layout'))

@section('js')
@stop

@section('css')
@stop

@section('page_title')
	- {{ Lang::get('lingos::sentry.create_new_permission') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-pencil-square-o fa-lg"></i>
		{{ Lang::get('lingos::sentry.create_new_permission') }}
	</h1>
@stop

@section('content')

@if (Sentry::check())

<div class="row">
<div class="row btn-toolbar pull-right" role="toolbar">
	<a href="{{ route('auth.permissions.index') }}" class="btn btn-info" title="{{ Lang::get('lingos::general.back') }}">
		<i class="fa fa-backward"></i>
		{{ Lang::get('lingos::general.back') }}
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
		->placeholder(Lang::get('lingos::sentry.module'))
		->autofocus()
	}}

	<br>

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">{{ Lang::get('lingos::sentry.generic_permissions') }}</h3>
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

	<div class="margin-top">
		{{ Former::actions()
			->success_submit(Lang::get('lingos::button.create'))
			->inverse_reset(Lang::get('lingos::button.reset'))
		}}
	</div>

	<div class="margin-top">
		<a class="btn btn-danger" href="{{ URL::route('auth.permissions.index') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
	</div>

{{ Former::close() }}
</div>

@else
	<div class="alert alert-warning">
		<h2>
			{{ Lang::get('lingos::auth.insufficient_permissions') }}
		</h2>
	</div>
@endif

@stop

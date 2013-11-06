@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ Lang::get('lingos::sentry.new_group') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-umbrella fa-lg"></i>
		{{ Lang::get('lingos::sentry.new_group') }}
	</h1>
@stop

@section('content')

@if (Sentry::check())

<div class="row">
<div class="row btn-toolbar pull-right" role="toolbar">
	<a href="{{ route('auth.groups.index') }}" class="btn btn-info" title="{{ Lang::get('lingos::general.back') }}">
		<i class="fa fa-backward"></i>
		{{ Lang::get('lingos::general.back') }}
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
		->placeholder(Lang::get('lingos::sentry.new_group'))
		->autofocus()
	}}

	<div class="margin-top">
		{{ Former::actions()
			->success_submit(Lang::get('lingos::button.create'))
			->inverse_reset(Lang::get('lingos::button.reset'))
		}}
	</div>

	<div class="margin-top">
		<a class="btn btn-warning" href="{{ URL::route('auth.groups.index') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
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

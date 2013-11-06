@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ Lang::get('lingos::sentry.ask_delete_group') }}';
		$(document).ready(function() {
			$('.js-activated').dropdownHover().dropdown();
		});
	</script>
@stop

@section('page_title')
	- {{ Lang::get('lingos::sentry.edit_group') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-umbrella fa-lg"></i>
		{{ Lang::get('lingos::sentry.edit_group') }}
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

{{ Former::horizontal_open(route('auth.groups.update', array($group->id)))->method('PUT') }}

	{{ Former::text('name', '')
		->prepend('<i class="fa fa-umbrella"></i>')
		->class('form-control has-error')
		->id('name')
		->value($group->name)
		->placeholder(Lang::get('lingos::sentry.edit_group'))
		->required()
		->autofocus()
	}}

	<div class="margin-top">
		{{ Former::actions()
			->success_submit(Lang::get('lingos::button.save_changes'))
			->inverse_reset(Lang::get('lingos::button.reset'))
		}}
	</div>

	<div class="margin-top">
		<a class="btn btn-warning" href="{{ URL::route('auth.groups.index') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
		<a href="{{ route('auth.groups.destroy', array($group->id)) }}"
			class="btn btn-danger action_confirm"
			data-method="post"
			title="{{ Lang::get('lingos::sentry.ask_delete_group') }}">
			<i class="fa fa-trash-o"></i>
			{{ Lang::get('lingos::sentry.delete_group') }}
		</a>
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

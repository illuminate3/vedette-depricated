@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ Lang::get('lingos::sentry.ask_delete_group') }}';
		$(document).ready(function() {
			$('.js-activated').dropdownHover().dropdown();
		});
	</script>
@stop

@section('page_title')
	- {{ Lang::get('lingos::sentry.group_command.edit') }}
@stop

@section('title')
	<i class="fa fa-umbrella fa-lg"></i>
	{{ Lang::get('lingos::sentry.group_command.edit') }}
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

		<hr>

		<div class="row btn-toolbar" role="toolbar">
			<div class="col-xs-6 col-md-4">
				<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ Lang::get('lingos::button.save_changes') }}">
				<div>
					<br>
				</div>
				<input class="btn-inverse btn" type="reset" value="{{ Lang::get('lingos::button.reset') }}">
				<a class="btn btn-warning" href="{{ URL::route('auth.groups.index') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
				<a href="{{ route('auth.groups.destroy', array($group->id)) }}"
					class="btn btn-danger action_confirm"
					data-method="post"
					title="{{ Lang::get('lingos::button.group.delete') }}">
					<i class="fa fa-trash-o"></i>
					{{ Lang::get('lingos::button.group.delete') }}
				</a>
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

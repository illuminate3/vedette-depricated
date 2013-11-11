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
	- {{ Lang::get('lingos::sentry.groups') }}
@stop

@section('title')
	<i class="fa fa-umbrella fa-lg"></i>
	{{ Lang::get('lingos::sentry.groups') }}
@stop

@section('content')
@if (Sentry::check())

	<div class="row">
	<div class="row btn-toolbar pull-right margin-bottom" role="toolbar">
		<a href="{{ route('auth.groups.create') }}" class="btn btn-success" title="{{ Lang::get('lingos::sentry.group_command.create') }}">
			<i class="fa fa-plus-circle"></i>
			{{ Lang::get('lingos::sentry.group_command.create') }}
		</a>
	</div>
	</div>

	@if (count($groups) == 0)
		<div class="alert alert-info">
			{{ Lang::get('lingos::sentry.group_error.not_found') }}
		</div>
	@else

	<div class="row">

	<table class="table table-hover">
		<thead>
		<tr>
			<th>{{ Lang::get('lingos::table.name') }}</th>
			<th>{{ Lang::get('lingos::table.actions') }}</th>
		</tr>
		</thead>
		<tbody>
		@foreach ($groups as $group)
		<tr>
			<td>{{ $group->name }}</td>
			<td>
				<a href="{{ route('auth.groups.edit', array($group->id)) }}"
					class="btn btn-primary" title="{{ Lang::get('lingos::sentry.group_command.edit') }}">
					<i class="fa fa-pencil"></i>
					{{ Lang::get('lingos::sentry.group_command.edit') }}
				</a>
				<a href="{{ route('auth.groups.permissions', array($group->id)) }}"
					class="btn btn-primary" title="{{ Lang::get('lingos::sentry.edit_group_permissions') }}">
					<i class="fa fa-pencil"></i>
					{{ Lang::get('lingos::sentry.edit_group_permissions') }}
				</a>
				<a href="{{ route('auth.groups.destroy', array($group->id)) }}"
					class="btn btn-danger action_confirm"
					data-method="post"
					title="{{ Lang::get('lingos::sentry.ask.delete_group') }}">
					<i class="fa fa-trash-o"></i>
					{{ Lang::get('lingos::sentry.ask.delete_group') }}
				</a>
			</td>
		</tr>
		@endforeach
		</tbody>
	</table>

	</div>

@endif

@else
	<div class="alert alert-warning">
		<h2>
			{{ Lang::get('lingos::sentry.permission_error.insufficient') }}
		</h2>
	</div>
@endif
@stop

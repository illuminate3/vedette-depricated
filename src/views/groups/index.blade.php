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
	- {{ Lang::get('lingos::sentry.groups') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-umbrella fa-lg"></i>
		{{ Lang::get('lingos::sentry.groups') }}
	</h1>
@stop

@section('content')

@if (Sentry::check())

<div class="row btn-toolbar pull-right margin-bottom" role="toolbar">
	<a href="{{ route('auth.groups.create') }}" class="btn btn-success" title="{{ Lang::get('lingos::sentry.create_new_group') }}">
		<i class="fa fa-plus-circle"></i>
		{{ Lang::get('lingos::sentry.create_new_group') }}
	</a>
</div>

@if (count($groups) == 0)
	<div class="alert alert-info">
		{{ Lang::get('vedette::groups.no_group') }}
	</div>
@else

<div class="row">


<table class="table table-hover">
	<thead>
	<tr>
		<th>{{ Lang::get('lingos::general.name') }}</th>
		<th class="span4"></th>
	</tr>
	</thead>
	<tbody>
	@foreach ($groups as $group)
	<tr>
		<td>{{ $group->name }}</td>
		<td>
			<a href="{{ route('auth.groups.edit', array($group->id)) }}"
				class="btn btn-primary" title="{{ Lang::get('lingos::sentry.edit_group') }}">
				<i class="fa fa-pencil"></i>
				{{ Lang::get('lingos::sentry.edit_group') }}
			</a>
			<a href="{{ route('auth.groups.permissions', array($group->id)) }}"
				class="btn btn-primary" title="{{ Lang::get('lingos::sentry.edit_group_permissions') }}">
				<i class="fa fa-pencil"></i>
				{{ Lang::get('lingos::sentry.edit_group_permissions') }}
			</a>
			<a href="{{ route('auth.groups.destroy', array($group->id)) }}"
				class="btn btn-danger action_confirm"
				data-method="post"
				title="{{ Lang::get('lingos::general.ask_delete_group') }}">
				<i class="fa fa-trash-o"></i>
				{{ Lang::get('lingos::sentry.delete_group') }}
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
			{{ Lang::get('lingos::auth.insufficient_permissions') }}
		</h2>
	</div>
@endif

@stop

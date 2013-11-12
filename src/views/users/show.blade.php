@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ Lang::get('lingos::sentry.ask.delete_user') }}';
	</script>
@stop

@section('page_title')
	- {{ Lang::get('lingos::general.user_profile') }}
@stop

@section('title')
	<i class="fa fa-user fa-lg"></i>
	{{ Lang::get('lingos::general.user_profile') }}
	&nbsp;&quot;{{ $user->first_name }}&nbsp;{{ $user->last_name }}&quot;
@stop

@section('content')
@if (Sentry::check())

	<div class="row">
	<div class="row btn-toolbar pull-right" role="toolbar">
		<a href="{{ route('auth.users.index') }}" class="btn btn-info" title="{{ Lang::get('lingos::button.back') }}">
			<i class="fa fa-backward"></i>
			{{ Lang::get('lingos::button.back') }}
		</a>
	</div>
	</div>

	<div class="row">

		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#info" data-toggle="tab">
					{{ Lang::get('lingos::general.information') }}
				</a>
			</li>
			<li>
				<a href="#status" data-toggle="tab">
					{{ Lang::get('lingos::general.status') }}
				</a>
			</li>
		</ul>

	<div id="myTabContent" class="tab-content">

	<div class="tab-pane active in padding-lg" id="info">

		<br>

		<table class="table table-striped table-hover">
			<tbody>
				<tr>
					<td>{{ Lang::get('lingos::general.first_name') }}</td>
					<td>{{ $user->first_name }}</td>
				</tr>
				<tr>
					<td>{{ Lang::get('lingos::general.last_name') }}</td>
					<td>{{ $user->last_name }}</td>
				</tr>
				<tr>
					<td>{{ Lang::get('lingos::general.email') }}</td>
					<td>{{ $user->email }}</td>
				</tr>
			</tbody>
		</table>

	</div>
	<div class="tab-pane fade padding-lg" id="status">

		<br>

		<table class="table table-striped table-hover">
			<tbody>
				<tr>
					<td>{{ Lang::get('lingos::sentry.groups') }}</td>
					<td>
						@foreach($user->groups as $group)
							{{ $group->getName() }}
						@endforeach
					</td>
				</tr>
				<tr>
					<td>{{ Lang::get('lingos::general.active') }}</td>
					<td>{{ ($user->activated) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}</td>
				</tr>
				<tr>
					<td>{{ Lang::get('lingos::sentry.banned') }}</td>
					<td>{{ ($throttles->banned) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}</td>
				</tr>
				<tr>
					<td>{{ Lang::get('lingos::sentry.suspended') }}</td>
					<td>{{ ($throttles->suspended) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}</td>
				<tr>
					<td>{{ Lang::get('lingos::general.date_activated') }}</td>
					<td>{{ $user->activated_at ? $user->activated_at : Lang::get('lingos::general.never_activated') }}</td>
				</tr>
				<tr>
					<td>{{ Lang::get('lingos::general.last_login') }}</td>
					<td>{{ is_null($user->last_login) ? Lang::get('lingos::general.never_visited') : $user->last_login }}</td>
				</tr>
			</tbody>
		</table>

	</div>

	</div>

	</div>

	<hr>

	<div class="row btn-toolbar" role="toolbar">
		<a href="{{ route('auth.users.destroy', array($user->id)) }}"
		class="btn btn-danger action_confirm"
		data-method="delete"
		title="{{ Lang::get('lingos::button.user.delete') }}">
			<i class="fa fa-trash-o"></i>
			{{ Lang::get('lingos::button.user.delete') }}
		</a>
	</div>

@else
	<div class="alert alert-warning">
		<h2>
			{{ Lang::get('lingos::sentry.permission_error.insufficient') }}
		</h2>
	</div>
@endif
@stop

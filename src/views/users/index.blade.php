@extends(Config::get('vedette::vedette_views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/twitter-bootstrap-hover-dropdown.js') }}"></script>
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ trans('lingos::sentry.ask.delete_user') }}';
		$(document).ready(function() {
			$('.js-activated').dropdownHover().dropdown();
		});
	</script>
@stop

@section('page_title')
	- {{ trans('lingos::general.users') }}
@stop

@section('title')
	<i class="fa fa-group fa-lg"></i>
	{{ trans('lingos::general.users') }}
@stop

@section('content')
@if (Sentry::check())

	<div class="row btn-toolbar pull-right margin-bottom" role="toolbar">
		<a href="{{ route('auth.users.create') }}" class="btn btn-success" title="{{ trans('lingos::button.user.new') }}">
			<i class="fa fa-plus-circle"></i>
			{{ trans('lingos::button.user.new') }}
		</a>
	</div>

	<br>

	<div class="row">
		<div class="span5">

	<table class="table table-striped table-hover">
		<thead>
			<tr>
			<th>{{ trans('lingos::table.name') }}</th>
			<th>{{ trans('lingos::table.email') }}</th>
			<th>{{ trans('lingos::table.groups') }}</th>
			<th>{{ trans('lingos::table.active') }}</th>
			<th>{{ trans('lingos::table.banned') }}</th>
			<th>{{ trans('lingos::table.suspended') }}</th>
			<th>{{ trans('lingos::table.active') }}</th>
			<th>{{ trans('lingos::table.last_visit') }}</th>
			<th>{{ trans('lingos::table.action') }}</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
			<tr>
				<td>
					{{ HTML::linkRoute('auth.users.show',$user->first_name.' '.$user->last_name, array($user->id)) }}
				</td>
				<td>
					{{ $user->email }}
				</td>
				<td>
					@foreach($user->groups as $group)
						{{ $group->getName() }}
					@endforeach
				</td>
				<td>
					{{ ($user->activated) ? trans('lingos::general.yes') : trans('lingos::general.no') }}
				</td>
				<td>
					{{ ($throttles->banned) ? trans('lingos::general.yes') : trans('lingos::general.no') }}
				</td>
				<td>
					{{ ($throttles->suspended) ? trans('lingos::general.yes') : trans('lingos::general.no') }}
				</td>
				<td>
					{{ $user->activated_at }}
				</td>
				<td>
					{{ is_null($user->last_login) ? trans('lingos::general.never_visited') : $user->last_login }}
				</td>
				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
							{{ trans('lingos::button.action') }}
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li>
								<a href="{{ route('auth.users.show', array($user->id)) }}">
									<i class="fa fa-user"></i>&nbsp;
									{{ trans('lingos::sentry.user_command.view') }}
								</a>
							</li>
							<li>
								<a href="{{ route('auth.users.edit', array($user->id)) }}">
									<i class="fa fa-pencil"></i>&nbsp;
									{{ trans('lingos::sentry.user_command.edit') }}
								</a>
							</li>
							<li>
								<a href="{{ route('auth.users.permissions', array($user->id)) }}">
									<i class="fa fa-wrench"></i>&nbsp;
									{{ trans('lingos::sentry.permissions') }}
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{ route('auth.users.destroy', array($user->id)) }}"
									class="action_confirm"
									data-method="delete"
									title="{{ trans('lingos::sentry.user_command.delete') }}">
									<i class="fa fa-trash-o"></i>
									{{ trans('lingos::sentry.user_command.delete') }}
								</a>
							</li>
						</ul>
					</div>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	</div>
	</div>

@else
	<div class="alert alert-warning">
		<h2>
			{{ trans('lingos::sentry.permission_error.insufficient') }}
		</h2>
	</div>
@endif
@stop

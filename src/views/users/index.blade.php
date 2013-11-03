@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('assets/js/twitter-bootstrap-hover-dropdown.js') }}"></script>
	<script src="{{ asset('assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ Lang::get('lingos::general.ask_delete_user') }}';
		$(document).ready(function() {
			$('.js-activated').dropdownHover().dropdown();
		});
	</script>
@stop

@section('page_title')
	- {{ Lang::get('lingos::general.users') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-group fa-lg"></i>
		{{ Lang::get('lingos::general.users') }}
	</h1>
@stop

@section('content')

@if (Sentry::check())


<div class="row btn-toolbar pull-right margin-bottom" role="toolbar">
	<a href="{{ route('auth.users.create') }}" class="btn btn-success" title="{{ Lang::get('vedette::vedette.create_new_user') }}">
		<i class="fa fa-plus-circle"></i>
		{{ Lang::get('lingos::general.new_user') }}
	</a>
</div>

<br>

<div class="row">
	<div class="span5">

<table class="table table-striped table-hover">
	<thead>
		<tr>
		<th>{{ Lang::get('lingos::general.name') }}</th>
		<th>{{ Lang::get('lingos::general.email') }}</th>
		<th>{{ Lang::get('lingos::sentry.groups') }}</th>
		<th>{{ Lang::get('lingos::general.active') }}</th>
		<th>{{ Lang::get('lingos::sentry.banned') }}</th>
		<th>{{ Lang::get('lingos::sentry.suspended') }}</th>
		<th>{{ Lang::get('lingos::general.active') }}</th>
		<th>{{ Lang::get('lingos::general.last_visit') }}</th>
		<th>{{ Lang::get('lingos::general.action') }}</th>
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
				{{ ($user->activated) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}
			</td>
			<td>
				{{ ($throttles->banned) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}
			</td>
			<td>
				{{ ($throttles->suspended) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}
			</td>
			<td>
				{{ $user->activated_at }}
			</td>
			<td>
				{{ is_null($user->last_login) ? Lang::get('lingos::general.never_visited') : $user->last_login }}
			</td>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" data-hover="dropdown">
						{{ Lang::get('lingos::general.action') }}
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="{{ route('auth.users.show', array($user->id)) }}">
								<i class="fa fa-user"></i>&nbsp;
								{{ Lang::get('lingos::general.view_user') }}
							</a>
						</li>
						<li>
							<a href="{{ route('auth.users.edit', array($user->id)) }}">
								<i class="fa fa-pencil"></i>&nbsp;
								{{ Lang::get('lingos::general.edit_user') }}
							</a>
						</li>
						<li>
							<a href="{{ route('auth.users.permissions', array($user->id)) }}">
								<i class="fa fa-wrench"></i>&nbsp;
								{{ Lang::get('lingos::sentry.permissions') }}
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="{{ URL::to('users/delete') }}/{{ $user->id}}"
								class="action_confirm"
								data-method="post"
								title="{{ Lang::get('lingos::general.delete_user') }}">
								<i class="fa fa-trash-o"></i>
								{{ Lang::get('lingos::general.delete_user') }}
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
	<h2>
		{{ Lang::get('lingos::auth.insufficient_permissions') }}
	</h2>
@endif

@stop

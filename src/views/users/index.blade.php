@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('assets/js/twitter-bootstrap-hover-dropdown.js') }}"></script>
	<script src="{{ asset('assets/js/admin.js') }}"></script>
	<script src="{{ asset('assets/js/bootbox.js') }}"></script>
	<script>
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

<div class="btn-toolbar pull-right" role="toolbar">
	<a href="{{ route('admin.users.create') }}" class="btn btn-success" rel="tooltip" title="{{ Lang::get('vedette::vedette.create_new_user') }}">
		<i class="fa fa-plus-circle"></i>
		{{ Lang::get('lingos::general.new_user') }}
	</a>
</div>

<br>

<div class="container">
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
		{{ HTML::linkRoute('admin.users.show',$user->first_name.' '.$user->last_name, array($user->id)) }}
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
			<a href="{{ route('admin.users.show', array($user->id)) }}">
				<i class="fa fa-user"></i>&nbsp;
				{{ Lang::get('lingos::general.view_user') }}
			</a>
		</li>
		<li>
			<a href="{{ route('admin.users.edit', array($user->id)) }}">
				<i class="fa fa-pencil"></i>&nbsp;
				{{ Lang::get('lingos::general.edit_user') }}
			</a>
		</li>
		<li>
			<a href="{{ route('admin.users.permissions', array($user->id)) }}">
				<i class="fa fa-wrench"></i>&nbsp;
				{{ Lang::get('lingos::sentry.permissions') }}
			</a>
		</li>
		<li>
<a href="{{ route('admin.users.destroy', array($user->id)) }}"
data-method="delete"
data-modal-text="{{ Lang::get('vedette::vedette.delete_user') }}">
				<i class="fa fa-trash-o"></i>&nbsp;
				{{ Lang::get('lingos::general.delete_user') }}
</a>
		</li>
		<li class="divider"></li>
		<li>
			@if ($user->isActivated())
<a href="{{ route('admin.users.deactivate', array($user->id)) }}" data-method="put" data-modal-text="{{ Lang::get('vedette::vedette.deactivate_user') }}">
					<i class="fa fa-power-off"></i>&nbsp;
					{{ Lang::get('lingos::general.deactivate') }}
</a>
			@else
<a href="{{ route('admin.users.activate', array($user->id)) }}" data-method="put" data-modal-text="{{ Lang::get('vedette::vedette.activate_user') }}">
					<i class="fa fa-dot-circle-o"></i>&nbsp;
					{{ Lang::get('lingos::general.activate') }}
</a>
			@endif
		</li>
		<li class="divider"></li>
		<li>
			<a href="{{ route('admin.users.throttling', array($user->id)) }}">
				<i class="fa fa-tachometer"></i>&nbsp;
				{{ Lang::get('lingos::sentry.throttling') }}
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
</div>




@stop

@section('help')
    <p class="lead">{{ Lang::get('lingos::general.users') }}</p>
    <p>
        From here you can create, edit or delete users. Also you can assign custom permissions to a single user.
    </p>
@stop

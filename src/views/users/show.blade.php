@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ Lang::get('lingos::general.user_profile') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-user fa-lg"></i>
		{{ Lang::get('lingos::general.user_profile') }}
		&nbsp;&quot;{{ $user->first_name }}&nbsp;{{ $user->last_name }}&quot;
	</h1>
@stop

@section('content')

<div class="row">
<div class="row btn-toolbar pull-right" role="toolbar">
	<a href="{{ route('admin.users.index') }}" class="btn btn-info" rel="tooltip" title="{{ Lang::get('lingos::general.back') }}">
		<i class="fa fa-backward"></i>
		{{ Lang::get('lingos::general.back') }}
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
				<td>{{ $user->activated_at }}</td>
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

@stop

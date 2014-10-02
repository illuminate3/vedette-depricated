@extends(Config::get('vedette.vedette_views.layout'))

@section('title')
@parent
	{{ Config::get('vedette.vedette_html.separator') }}
	{{ trans('lingos::general.dashboard') }}
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('inline-scripts')
$(document).ready(function() {

});
@stop

@section('content')
	<div class="row">


@if (Auth::check())
	@if (Auth::user()->hasRoleWithName('Admin'))
	has role admin
	@endif
	@if (Auth::user()->hasRoleWithName('User'))
	has role User
	@endif
@endif

<br>


		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h1>Administration</h1>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">
			<table class="table">
				<thead>
				<tr>
					<th colspan="2">Users</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Bootstrap::linkRoute('admin.users.create', 'Add') }}</td>
						<td>{{ Bootstrap::linkRoute('admin.users.index', 'View') }}</td>
					</tr>
				</tbody>
			</table>
			<table class="table">
				<thead>
				<tr>
					<th colspan="2">Roles</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ Bootstrap::linkRoute('admin.roles.create', 'Add') }}</td>
						<td>{{ Bootstrap::linkRoute('admin.roles.index', 'View') }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@stop

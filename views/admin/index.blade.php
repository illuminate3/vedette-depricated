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
<h1>
	<i class="fa fa-dashboard fa-lg"></i>
	{{ trans('lingos::general.dashboard') }}
	<hr>
</h1>
</div>

<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-group fa-2x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">
							{{ $countUsers }}
						</div>
						<div>
							{{ trans('lingos::account.users') }}
						</div>
					</div>
				</div>
			</div>
			<a href="admin/users">
				<div class="panel-footer">
					<span class="pull-left">
						{{ trans('lingos::general.view') }}
					</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>



{{--
<div class="row">
{{ dd(Auth::user()->profile->user_id) }}

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
						<td>{{ Bootstrap::linkRoute('users.create', 'Add') }}</td>
						<td>{{ Bootstrap::linkRoute('users.index', 'View') }}</td>
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
						<td>{{ Bootstrap::linkRoute('roles.create', 'Add') }}</td>
						<td>{{ Bootstrap::linkRoute('roles.index', 'View') }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
--}}


{{--
<div class="row">
	<div class="col-md-12">
	<h3>Users</h3>
	{{ $table->render() }}
	{{ $table->script() }}
	</div>
</div>
--}}
@stop

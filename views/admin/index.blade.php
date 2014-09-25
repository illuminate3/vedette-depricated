@extends('layouts.master')
@section('content')
	<div class="row">
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

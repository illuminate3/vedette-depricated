@extends('layouts.master')

@section('title')

Administration | Users

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<h1>Users</h1>

		</div>

		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">

			<table class="table">

				<thead>

				<tr>

					<th>#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Roles</th>
					<th>Actions</th>

				</tr>

				</thead>

				<tbody>

				@if (count($users))

					@foreach ($users as $user)

						<tr>

							<td>{{ $user->id }}</td>
							<td>{{ $user->present()->name() }}</td>
							<td>{{ $user->present()->email() }}</td>
							<td>{{ $user->present()->roles() }}</td>
							<td width="20%">
								{{ Form::open(array('route' => array('admin.users.destroy', $user->id), 'role' => 'form', 'method' => 'delete', 'class' => 'form-inline')) }}

									{{ Bootstrap::linkRoute('admin.users.edit', 'Edit', array($user->id)) }}
									{{ Bootstrap::submit('Delete', array('class' => 'btn btn-danger')) }}

								{{ Form::close() }}
							</td>

						</tr>

					@endforeach

				@else

					<tr>

						<td colspan="3">None to display</td>

					</tr>

				@endif

				</tbody>

			</table>

			{{ Bootstrap::linkRoute('admin.index', 'Back') }}

		</div>

	</div>

@stop

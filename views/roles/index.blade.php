@extends('layouts.master')

@section('title')

Administration | Roles

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<h1>Roles</h1>

		</div>

		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">

			<table class="table">

				<thead>

				<tr>

					<th>#</th>
					<th>Name</th>
					<th>Active?</th>
					<th>Actions</th>

				</tr>

				</thead>

				<tbody>

				@if (count($roles))

					@foreach ($roles as $role)

						<tr>

							<td>{{ $role->id }}</td>
							<td>{{ $role->present()->name() }}</td>
							<td>{{ $role->present()->active() }}</td>
							<td width="20%">
								{{ Form::open(array('route' => array('admin.roles.destroy', $role->id), 'role' => 'form', 'method' => 'delete', 'class' => 'form-inline')) }}

									{{ Bootstrap::linkRoute('admin.roles.edit', 'Edit', array($role->id)) }}
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

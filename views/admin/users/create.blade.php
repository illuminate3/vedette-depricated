@extends('layouts.master')

@section('title')

Administration | Create User

@stop

@section('content')

	<div class="row-fluid">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<h1>Create User</h1>

		</div>

		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">

			{{ Form::open(array('route' => 'admin.users.store', 'role' => 'form')) }}

				{{ Bootstrap::text('name', 'Name', null, $errors) }}

				{{ Bootstrap::email('email', 'Email address', null, $errors) }}

				{{ Bootstrap::password('password', 'Password', $errors) }}

				{{ Bootstrap::password('password_confirmation', 'Password confirmation', $errors) }}

				<h5><strong>Roles</strong></h5>

				@foreach (Role::All() as $role)

					{{ Bootstrap::checkbox('roles[]', $role->present()->name(), $role->id) }}

				@endforeach

				{{ Bootstrap::linkRoute('admin.index', 'Back') }}

				{{ Bootstrap::submit('Save') }}

			{{ Form::close() }}

		</div>

	</div>

@stop

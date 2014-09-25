@extends('layouts.master')

@section('title')

Administration | Edit User

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<h1>Edit User</h1>

		</div>

		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">

			{{ Form::open(array('route' => array('admin.users.update', $user->id), 'role' => 'form', 'method' => 'put')) }}

				{{ Form::hidden('user', $user->id) }}

				{{ Bootstrap::text('name', 'Name', $user->name, $errors) }}

				{{ Bootstrap::email('email', 'Email address', $user->email, $errors) }}

				{{ Bootstrap::password('password', 'Password', $errors) }}

				{{ Bootstrap::password('password_confirmation', 'Password confirmation', $errors) }}

				<h5><strong>Roles</strong></h5>

				@foreach (Role::All() as $role)

					{{ Bootstrap::checkbox('roles[]', $role->present()->name(), $role->id, $user->hasRole($role->id)) }}

				@endforeach

				{{ Bootstrap::linkRoute('admin.users.index', 'Back') }}

				{{ Bootstrap::submit('Save') }}

			{{ Form::close() }}

		</div>

	</div>

@stop

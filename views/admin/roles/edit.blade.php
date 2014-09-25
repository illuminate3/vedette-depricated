@extends('layouts.master')

@section('title')

Administration | Edit Role

@stop

@section('content')

	<div class="row-fluid">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<h1>Edit Role</h1>

		</div>

		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">

			{{ Form::open(array('route' => array('admin.roles.update', $role->id), 'role' => 'form', 'method' => 'put')) }}

				{{ Form::hidden('role', $role->id) }}

				{{ Bootstrap::text('name', 'Name', $role->name, $errors) }}

				{{ Bootstrap::checkbox('active', 'Active', 1, $role->active) }}

				{{ Bootstrap::linkRoute('admin.roles.index', 'Back') }}

				{{ Bootstrap::submit('Save') }}

			{{ Form::close() }}

		</div>

	</div>

@stop

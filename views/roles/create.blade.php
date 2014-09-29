@extends('layouts.master')

@section('title')

Administration | Create Role

@stop

@section('content')

	<div class="row-fluid">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<h1>Create Role</h1>

		</div>

		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">

			{{ Form::open(array('route' => 'admin.roles.store', 'role' => 'form')) }}

				{{ Bootstrap::text('name', 'Name', null, $errors) }}

				{{ Bootstrap::checkbox('active', 'Active') }}

				{{ Bootstrap::linkRoute('admin.index', 'Back') }}

				{{ Bootstrap::submit('Save') }}

			{{ Form::close() }}

		</div>

	</div>

@stop

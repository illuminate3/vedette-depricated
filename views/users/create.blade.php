@extends('layouts.master')

@section('title')

Register

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<h1>Register</h1>

		</div>

		<div class="col-xs-12 col-sm-8 col-sm-offset-1 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">

			{{ Form::open(array('route' => 'user.store', 'role' => 'form', 'class' => 'well')) }}

				{{ Bootstrap::text('name', 'Name', null, $errors) }}

				{{ Bootstrap::email('email', 'Email address', null, $errors) }}

				{{ Bootstrap::password('password', 'Password', $errors) }}

				{{ Bootstrap::password('password_confirmation', 'Password confirmation', $errors) }}

				{{ Bootstrap::linkRoute('login', 'Login') }}

				{{ Bootstrap::submit('Register') }}

			{{ Form::close() }}

		</div>

	</div>

@stop

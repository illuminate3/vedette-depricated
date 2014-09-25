@extends('layouts.master')

@section('title')

Login

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<h1>Login</h1>

		</div>

		<div class="col-xs-12 col-sm-8 col-sm-offset-1 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">

			{{ Form::open(array('route' => 'sessions.store', 'role' => 'form', 'class' => 'well')) }}

				{{ Bootstrap::email('email', 'Email address', null, $errors) }}

				{{ Bootstrap::password('password', 'Password', $errors) }}

				{{ Bootstrap::checkbox('remember_me', 'Remember') }}

				{{ Bootstrap::linkRoute('password.remind', 'Forgotten Password?') }}

				{{ Bootstrap::submit('Login') }}

			{{ Form::close() }}

		</div>

	</div>

@stop

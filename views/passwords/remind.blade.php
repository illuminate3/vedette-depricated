@extends('layouts.master')

@section('title')

Password Reminder

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<h1>Password Reminder</h1>

		</div>

		<div class="col-xs-12 col-sm-8 col-sm-offset-1 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">

			{{ Form::open(array('route' => 'password.request', 'role' => 'form')) }}

				{{ Bootstrap::email('email', 'Email address', null, $errors) }}

				{{ Bootstrap::linkRoute('login', 'Back') }}

				{{ Bootstrap::submit('Send') }}

			{{ Form::close() }}

		</div>

	</div>

@stop

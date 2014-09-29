@extends('layouts.master')

@section('title')

Profile

@stop

@section('content')

	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
{{--
			<h1>Welcome {{ Auth::user()->present()->name }}</h1>
--}}
		</div>

		<div class="col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-10 col-lg-offset-1">

			<h4>Update Account</h4>

			<p>Want to update your account? Press the button below:</p>

			{{ Bootstrap::linkRoute('user.edit', 'Update', array($user->id)) }}

			<h4>Delete Account</h4>

			<p>Want to delete your account? Press the button below:</p>

			{{ Form::open(array('route' => array('user.destroy', $user->id), 'role' => 'form', 'method' => 'delete')) }}

				{{ Bootstrap::submit('Destroy', array('class' => 'btn btn-danger')) }}

			{{ Form::close() }}

		</div>

	</div>

@stop

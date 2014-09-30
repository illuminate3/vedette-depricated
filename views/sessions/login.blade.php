@extends('layouts.login')

{{-- Web site Title --}}
@section('title')
	{{trans('pages.login')}}
@stop

@section('styles')
{{--
--}}
	<link rel="stylesheet" href="{{ URL::asset('assets/vendors/backstretch/css/backstretch.css') }}">
		<!-- Google Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700,300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>

@stop

@section('scripts')
{{--
	<script src="{{ URL::asset('assets/vendors/backstretch/backstretch.js') }}"></script>
--}}
	<script src="{{ URL::asset('assets/vendors/backstretch/jquery.backstretch.min.js') }}"></script>
	<script src="{{ URL::asset('assets/vendors/nnattawat-flip/jquery.flip.js') }}"></script>
@stop

@section('inline_scripts')
jQuery(document).ready(function($) {
	$.backstretch([
	  "{{Config::get('site.image_1')}}",
	  "{{Config::get('site.image_2')}}",
	], {duration: 3000, fade: 750});
});
@stop

@section('inline_scripts')
$(document).ready(function(){
})
@stop

@section('inline_styles')
@stop

{{-- Content --}}
@section('content')
<div class="row centered">
<div class="col-md-4 col-md-offset-4">

<div class="panelBox">
	{{ Form::open(array('action' => 'SessionController@store')) }}

<div class="front">
	<div class="pull-right clearfix">
		<i class="fa fa-info-circle fa-lg flipLink" id="flipToBack"></i>
	</div>
	<h2>

{{-- Session::get('userId')  Session::get('email') --}}
{{-- Config::get('site.app_name') --}}
		{{trans('auth.sign_on')}}
	</h2>
	<hr>
	<a href="o-auth/login" class="btn btn-success btn-block" href="#">
		<i class="fa fa-google fa-lg"></i> {{trans('auth.sign_on')}}
	</a>
</div><!-- front -->


<div class="back">
	<div class="pull-right clearfix">
		<i class="fa fa-google fa-lg flipLink" id="flipToFront"></i>
	</div>
	<h2>
{{-- Config::get('site.app_name') --}}
		{{trans('auth.log_in')}}
	</h2>
	<hr>


		{{ $message = Session::get('message') }}
		@if( isset($message) )
			<div class="alert alert-success">{{$message}}</div>
		@endif
		@if($errors && ! $errors->isEmpty() )
			@foreach($errors->all() as $error)
				<div class="alert alert-danger">{{$error}}</div>
			@endforeach
		@endif

	<div class="form-group {{ ($errors->has('email')) ? 'has-error' : '' }}">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
			{{Form::email('email', '', ['id' => 'email', 'class' => 'form-control', 'placeholder' => trans('general.email'), 'required', 'autocomplete' => 'off', 'autofocus'])}}
			{{ ($errors->has('email') ? $errors->first('email') : '') }}
		</div>
	</div>

	<div class="form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
			{{Form::password('password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => trans('auth.password'), 'required', 'autocomplete' => 'off'])}}
			{{ ($errors->has('password') ?  $errors->first('password') : '') }}
		</div>
	</div>

	{{ Form::checkbox('rememberMe', 'rememberMe') }} {{trans('auth.remember_me')}}

	<br>
	<br>


	{{ Form::submit(trans('auth.log_in'), array('class' => 'btn btn-success btn-block'))}}

{{--
	<hr>
	<a class="btn btn-link" href="{{ route('forgotPasswordForm') }}">{{trans('users.forgot')}}?</a>
--}}

	<hr>
	<a href="o-auth/login" class="btn btn-info btn-block" href="#">
		<i class="fa fa-google fa-lg"></i> {{trans('auth.sign_on')}}
	</a>

</div><!-- back -->

	{{ Form::close() }}
</div><!-- panelBox -->

</div>
</div>
@stop

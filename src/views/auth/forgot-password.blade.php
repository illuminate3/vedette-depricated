@extends('frontend/layouts/default')

@section('css')
@stop

@section('page_title')
	- {{ Lang::get('lingos::auth.forgot_password') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-external-link fa-lg"></i>
		{{ Lang::get('lingos::auth.forgot_password') }}
	</h1>
@stop

@section('content')

	{{ Former::horizontal_open(route('admin.register')) }}
	{{ Former::horizontal_open(route('admin.login'))
		->id('form-forgot')
		->secure()
		->rules(['name' => 'required'])
		->method('POST')
	}}

		{{ Former::text('email', '')
			->prepend('<i class="fa fa-envelope-o"></i>')
			->class('form-control')
			->id('email')
			->placeholder(Lang::get('lingos::general.email'))
		}}

	<hr>

	<div class="margin-top">
		{{ Former::actions()
			->success_submit(Lang::get('lingos::button.send'))
			->inverse_reset(Lang::get('lingos::button.reset'))
		}}
	</div>

	<div class="margin-top">
		<a class="btn btn-danger" href="{{ URL::route('home') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
	</div>

	{{ Former::close() }}



<div class="page-header">
	<h3>Forgot Password</h3>
</div>
<form method="post" action="" class="form-horizontal">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

	<!-- Email -->
	<div class="control-group{{ $errors->first('email', ' error') }}">
		<label class="control-label" for="email">Email</label>
		<div class="controls">
			<input type="text" name="email" id="email" value="{{ Input::old('email') }}" />
			{{ $errors->first('email', '<span class="help-block">:message</span>') }}
		</div>
	</div>

	<!-- Form actions -->
	<div class="control-group">
		<div class="controls">
			<a class="btn" href="{{ route('home') }}">Cancel</a>

			<button type="submit" class="btn">Submit</button>
		</div>
	</div>
</form>
@stop

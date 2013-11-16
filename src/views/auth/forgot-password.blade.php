@extends(Config::get('vedette::vedette_views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ trans('lingos::auth.forgot_password') }}
@stop

@section('title')
	<i class="fa fa-external-link fa-lg"></i>
	{{ trans('lingos::auth.forgot_password') }}
@stop

@section('content')

	{{ Former::horizontal_open()
		->id('form-forgot')
		->secure()
		->rules(['email' => 'required'])
	}}

	{{ Former::text('email', '')
		->prepend('<i class="fa fa-envelope-o"></i>')
		->class('form-control has-error')
		->id('email')
		->placeholder(trans('lingos::general.email'))
	}}

	<br>

	<div class="row btn-toolbar" role="toolbar">
		<div class="col-xs-6 col-md-4">
			<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ trans('lingos::button.send') }}">
			<div>
				<br>
			</div>
			<input class="btn-inverse btn" type="reset" value="{{ trans('lingos::button.reset') }}">
			<a class="btn btn-warning" href="{{ route('vedette.home') }}"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
		</div>
	</div>

	{{ Former::close() }}

@stop

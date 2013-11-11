@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ Lang::get('lingos::general.dashboard') }}
@stop

@section('title')
	<i class="fa fa-dashboard fa-lg"></i>
	{{ Lang::get('lingos::general.dashboard') }}
@stop

@section('content')


	<div class="row btn-toolbar" role="toolbar">
		<div class="col-xs-6 col-md-4">
			<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ Lang::get('lingos::button.sign_in') }}">
			<div>
				<br>
			</div>
			<a class="btn btn-warning" href="{{ URL::route('home') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
			<a class="btn btn-primary" href="{{ URL::route('signup') }}"><i class="fa fa-plus-circle"></i>{{ Lang::get('lingos::button.register') }}</a>
			<a class="btn btn-info" href="{{ URL::route('forgot-password') }}"><i class="fa fa-external-link"></i>{{ Lang::get('lingos::button.forgot_password') }}</a>
		</div>
	</div>

@stop

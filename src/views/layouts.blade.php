<!DOCTYPE html>
<!--[if lt IE 7]>       <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>          <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>          <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js"> <!--<![endif]-->

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<!-- site title ================================================== -->
<title>
{{ $vedette['title'] }}
@show
@section('page_title')
@show
</title>

<meta name="description" content="{{ $vedette['description'] }}">
<meta name="viewport" content="width=device-width">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if IE]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lt IE 9]>
<script src="//ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.1/css/font-awesome.min.css" rel="stylesheet">
<link href="{{ asset('packages/illuminate3/vedette/assets/css/vedette.css') }}" rel="stylesheet">

<!-- CSS ================================================== -->
@section('css')
@show

</head>
<body>

<!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#">{{ $vedette['site_name'] }}</a>
	</div>

<ul class="nav navbar-nav navbar-right">
	@if (Sentry::check())
	<li class="dropdown{{ (Request::is('auth*') ? ' active' : '') }}">
		<a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="{{ route('vedette.home') }}" data-hover="dropdown">
			<i class="fa fa-user"></i>
			{{ Sentry::getUser()->first_name }}
			<b class="caret"></b>
		</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			@if(Sentry::getUser()->hasAccess('admin'))
				<li><a href="{{ route('vedette.users') }}"><i class="fa fa-wrench"></i>{{ trans('lingos::general.users') }}</a></li>
				<li><a href="{{ route('vedette.groups') }}"><i class="fa fa-wrench"></i>{{ trans('lingos::sentry.groups') }}</a></li>
				<li><a href="{{ route('vedette.permissions') }}"><i class="fa fa-wrench"></i>{{ trans('lingos::sentry.permissions') }}</a></li>
				<li><a href="{{ route('vedette.admin') }}"><i class="fa fa-gear"></i>{{ trans('lingos::general.administration') }}</a></li>
			@endif
			<li class="divider"></li>
			<li><a href="{{ route('vedette.logout') }}"><i class="fa fa-power-off"></i>{{ trans('lingos::auth.log_out') }}</a></li>
		</ul>
	</li>
	@else
		<li {{ (Request::is('auth/login') ? 'class="active"' : '') }}><a href="{{ route('vedette.login') }}">{{ trans('lingos::auth.sign_in') }}</a></li>
		<li {{ (Request::is('auth/register') ? 'class="active"' : '') }}><a href="{{ route('vedette.register') }}">{{ trans('lingos::auth.sign_up') }}</a></li>
	@endif
</ul>

	</div><!--/.nav-collapse -->
</div><!--/.navbar-fixed-top -->


<!-- Wrap all page content here -->
<div id="wrap">
	<div class="container">

<!-- section title ================================================== -->
	<div class="page-header">
		<h1>
			@section('title')
			@show
		</h1>
	</div>

<!-- notifications ================================================== -->
	@if (count($errors->all()) > 0)
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	Please check the form below for errors
	</div>
	@endif

	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ $message }}
	</div>
	@endif

	@if ($message = Session::get('error'))
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ $message }}
	</div>
	@endif

	@if ($message = Session::get('warning'))
	<div class="alert alert-warning">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ $message }}
	</div>
	@endif

	@if ($message = Session::get('info'))
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		{{ $message }}
	</div>
	@endif

<!-- content ================================================== -->
	@section('content')
	@show

	</div>
</div>

<br>

<div id="footer">
<div class="container">
	<div class="row-fluid">
		<div class="span12">
			<div class="span4">
				<p class="muted pull-right">
					Generated in {{ round((microtime(1) - LARAVEL_START), 4) }} sec.
				</p>
			</div>
			<div class="span8">
				<p class="muted credit">
					&copy;
					<a href="https://github.com/illuminate3/vedette">{{ $vedette['site_name'] }}</a>
					&copy;
					<a href="https://github.com/illuminate3">illuminate3</a>
					{{ date('Y') }} All rights reserved.
				</p>
			</div>
		</div>
	</div>
</div>
</div>


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>

<script src="{{ asset('packages/illuminate3/vedette/assets/js/twitter-bootstrap-hover-dropdown.js') }}"></script>
<script>
	$(document).ready(function() {
		$('.js-activated').dropdownHover().dropdown();
	});
</script>

<!-- Javascripts ================================================== -->
@section('js')
@show

</body>
</html>

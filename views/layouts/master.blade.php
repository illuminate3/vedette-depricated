<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>
		@section('title')
			Laravel 4 Sample Site
		@show
	</title>
	<meta name="keywords" content="" />
	<meta name="author" content="illuminate3" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
	<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
	{{ Bootstrap::cssBoot() }}
	<link rel="stylesheet" type="text/css" href="{{{ asset('assets/css/default.css') }}}">
	@yield('styles')
</head>
<body>
	@include('layouts.navigation')
	@include('layouts.content')
	@include('layouts.footer')
</body>
{{ Bootstrap::js2x() }}
@yield('scripts')
</html>

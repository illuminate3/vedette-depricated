<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
<div class="container">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		{{ HTML::linkRoute(
			Config::get('vedette.vedette_routes.home'),
			Config::get('vedette.vedette_html.project_name'),
			null,
			array(
				'class' => 'navbar-brand'
			)
		) }}
	</div>
	<div class="collapse navbar-collapse">
		<ul class="nav navbar-nav">
			<li {{ (Request::is('/') ? ' class="active"' : '') }}>
				{{ HTML::linkRoute(
					'home',
					trans('lingos::general.home')
				) }}
			</li>
		</ul>
		<ul class="nav navbar-nav pull-right">
			@if (Auth::check())
				@if (Auth::user()->hasRoleWithName('Admin'))
					<li {{ (Request::is('admin*') ? ' class="active"' : '') }}>{{ HTML::linkRoute('admin.index', 'Administration') }}</li>
				@endif
{{--
				<li {{ (Request::is('user*') ? ' class="active"' : '') }}>{{ HTML::linkRoute('user.show', 'Logged in as ' . Auth::user()->email, array(Auth::user()->id)) }}</li>
--}}
				<li>{{ HTML::linkRoute('logout', 'Logout') }}</li>
			@else
				<li {{ (Request::is('login') ? ' class="active"' : '') }}>{{ HTML::linkRoute('login', 'Login') }}</li>
				<li {{ (Request::is('register') ? ' class="active"' : '') }}>{{ HTML::linkRoute('register', 'Register') }}</li>
			@endif
		</ul>
	</div>
</div>
</div>

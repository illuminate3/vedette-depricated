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
	@include(Config::get('vedette.vedette_html.include_nav'))
</ul>


<ul class="nav navbar-nav pull-right">
	@if (Auth::check())

	<li class="dropdown">
		<img
			src="{{ asset(Session::get('userPicture')) }}"
			alt="{{ Auth::user()->email }}"
			class="img-circle show-profile"
		/>
	</li>
	<li class="dropdown">
{{--
		<a class="dropdown-toggle {{ (Request::is('auth*') ? ' active' : '') }}" data-toggle="dropdown" href="#">
--}}
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			{{ Auth::user()->email }}
			<b class="caret"></b>
		</a>
		<ul class="dropdown-menu">
			@if (Auth::user()->hasRoleWithName('Admin'))
				<li>
					<a href="{{ route('admin.index') }}"><i class="fa fa-dashboard fa-fw"></i>{{ trans('lingos::general.administration') }}</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="{{ route('users.index') }}"><i class="fa fa-users fa-fw"></i>{{ trans('lingos::account.users') }}</a>
				</li>
				<li>
					<a href="{{ route('roles.index') }}"><i class="fa fa-gavel fa-fw"></i>{{ trans('lingos::role.roles') }}</a>
				</li>
{{--
				<li>
					<a href="{{ route('vedette.permissions') }}"><i class="fa fa-wrench fa-fw"></i>{{ trans('lingos::permission.permissions') }}</a>
				</li>
--}}
				<li class="divider"></li>
			@endif
			<li>
				<a href="{{ route('profiles.show', Auth::user()->id) }}"><i class="fa fa-gear fa-fw"></i>{{ trans('lingos::account.profile') }}</a>
			</li>
			<li class="divider"></li>
			<li>
				<a href="{{ route('logout') }}"><i class="fa fa-sign-out fa-fw"></i>{{ trans('lingos::auth.log_out') }}</a>
			</li>
		</ul>
	</li>



{{--
	<li {{ (Request::is('user*') ? ' class="active"' : '') }}>{{ HTML::linkRoute('user.show', 'Logged in as ' . Auth::user()->email, array(Auth::user()->id)) }}</li>
--}}
	@else
	<li {{ (Request::is('login') ? ' class="active"' : '') }}>{{ HTML::linkRoute('login', 'Login') }}</li>
	<li {{ (Request::is('register') ? ' class="active"' : '') }}>{{ HTML::linkRoute('register', 'Register') }}</li>
	@endif
</ul>

</div>


</div>
</div>

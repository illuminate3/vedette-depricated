<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="well">
<div class="row">

<div class="col-md-4">
		<img src="{{ asset('assets/images/DistrictSeal.png') }}" />
</div>
<div class="col-md-8">
	<h1>
	Bryant Public School District
	</h1>
	<br>
	<blockquote>
		Human Resource Database
		<br>
		> simple
		<br>
		> informative
	</blockquote>
</div>

</div><!-- row -->
</div><!-- well -->


<!-- Example row of columns -->
<div class="row">

<div class="col-md-4">
	<h2>
		Sites
	</h2>
	<p>
		Schools, Buildings and Centers
	</p>
	<p>
		{{ Bootstrap::linkRouteIcon(
			'sites.index',
			trans('lingos::hr.sites'),
			'chevron-right fa-fw',
			array(),
			array(
				'class' => 'btn btn-primary btn-block',
				'title' => trans('lingos::general.view')
			)
		) }}
	</p>
</div>

<div class="col-md-4">
	<h2>
		Staff
	</h2>
	<p>
		Teachers and Staff
	</p>
	<p>
		{{ Bootstrap::linkRouteIcon(
			'profiles.index',
			trans('lingos::general.staff'),
			'chevron-right fa-fw',
			array(),
			array(
				'class' => 'btn btn-primary btn-block',
				'title' => trans('lingos::general.view')
			)
		) }}
	</p>
</div>

<div class="col-md-4">
@if (Auth::check())
	<h2>
		Your Profile
	</h2>
	<p>
		Check your information
	</p>
	<p>
		{{ Bootstrap::linkRouteIcon(
			'profiles.show',
			trans('lingos::hr.profile'),
			'chevron-right fa-fw',
			array(Auth::user()->id),
			array(
				'class' => 'btn btn-primary btn-block',
				'title' => trans('lingos::general.view')
			)
		) }}
	</p>
@endif
</div>

</div><!-- row -->

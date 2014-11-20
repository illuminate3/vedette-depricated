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
		Bryant Asset Management Database
		<br>
		> assets
		<br>
		> items
	</blockquote>
</div>

</div><!-- row -->
</div><!-- well -->


<!-- Example row of columns -->
<div class="row">

<div class="col-md-4">
	<h2>
		{{ trans('lingos::general.assets') }}
	</h2>
	<p>
		Computers, Blackboards, Cameras
	</p>
	<p>
		{{ Bootstrap::linkRouteIcon(
			'asset.index',
			trans('lingos::general.assets'),
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
		{{ trans('lingos::general.items') }}
	</h2>
	<p>
		Catalog of Items
	</p>
	<p>
		{{ Bootstrap::linkRouteIcon(
			'items.index',
			trans('lingos::general.items'),
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
		{{ trans('lingos::general.rooms') }}
	</h2>
	<p>
		Where things are located
	</p>
	<p>
		{{ Bootstrap::linkRouteIcon(
			'rooms.index',
			trans('lingos::general.rooms'),
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


@if (isset($menu2))
	{{ HTML::navy($menu2) }}
@endif

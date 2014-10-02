@extends(Config::get('vedette.vedette_views.layout'))

@section('title')
@parent
	{{ Config::get('vedette.vedette_html.separator') }}
	{{ trans('lingos::general.dashboard') }}
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('inline-scripts')
$(document).ready(function() {

});
@stop

@section('content')
<div class="row">


@if (Auth::check())
	@if (Auth::user()->hasRoleWithName('Admin'))
	has role admin
	@endif
	@if (Auth::user()->hasRoleWithName('User'))
	has role User
	@endif
@endif

<br>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="well">
<div class="container">
<h1>Hello, Vedette!</h1>
<br>
<blockquote>> vedette |vi'det|(also vidette )
<br>
> noun
<br>
> historical, a mounted sentry positioned beyond an army's outposts to observe the movements of the enemy.
</blockquote>
<br>
A simple role/permission authentication package for Laravel 4.2.
<br>
	<a class="btn btn-primary btn-lg" role="button">Learn more &raquo;</a>
</p>
</div>
</div>

<div class="container">
<!-- Example row of columns -->
<div class="row">

<div class="col-md-4">
<h2>Simple and Easy!</h2>
<p>
Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
</p>
<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
</div>

<div class="col-md-4">
<h2>Includes!</h2>
BootAwesome
<br>
Lingos
<br>
<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
</div>

<div class="col-md-4">
<h2>Configurable!</h2>
<p>
Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
</p>
<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
</div>



</div>
</div>
@stop

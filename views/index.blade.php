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
	@include(Config::get('vedette.vedette_html.ipsum_content'))
</div>
@stop

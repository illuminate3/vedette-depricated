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

@section('menu')
    @if (isset($menu))
    <ul class="nav navbar-nav">
        @foreach ($menu as $item)
        <li @if(isset($item['active']) && $item['active'])class="active"@endif>
            <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
        </li>
        @endforeach
    </ul>
    @endif

@stop


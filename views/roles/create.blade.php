@extends(Config::get('vedette.vedette_views.layout'))

@section('title')
@parent
	{{ Config::get('vedette.vedette_html.separator') }}
	{{ trans('lingos::role.command.create') }}
@stop

@section('styles')
	<link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/css/datepicker3.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/chosen_v1.0.0/chosen.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/chosen_v1.0.0/chosen_bootstrap.css') }}">
@stop

@section('scripts')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>

	<script src="{{ asset('assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('assets/vendors/bootstrap-datepicker/js/datepicker-settings.js') }}"></script>
	<script src="{{ asset('assets/vendors/chosen_v1.0.0/chosen.jquery.min.js') }}"></script>
@stop

@section('inline-scripts')
$(document).ready(function(){

	var config = {
		'.chosen-select'           : {},
		'.chosen-select-deselect'  : {allow_single_deselect:true},
		'.chosen-select-no-single' : {disable_search_threshold:10},
		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		'.chosen-select-width'     : {width:"95%"}
	}
	for (var selector in config) {
		$(selector).chosen(config[selector]);
	}

});
@stop

@section('content')
<div class="row">
<h1>
	<p class="pull-right">
	{{ Bootstrap::linkIcon(
		'roles.index',
		trans('lingos::button.back'),
		'chevron-left fa-fw',
		array('class' => 'btn btn-default')
	) }}
	</p>
	<i class="fa fa-edit fa-lg"></i>
	{{ trans('lingos::role.command.create') }}
	<hr>
</h1>
</div>


<div class="row">
{{ Form::open(
	[
		'route' => array('roles.store'),
		'role' => 'form'
	]
) }}


	{{ Bootstrap::text(
		'name',
		trans('lingos::general.name'),
		null,
		$errors,
		'gavel fa-fw',
		[
			'id' => 'name',
			'placeholder' => trans('lingos::general.name'),
			'required',
			'autofocus'
		]
	) }}

	{{ Bootstrap::text(
		'description',
		trans('lingos::general.description'),
		null,
		$errors,
		'info fa-fw',
		[
			'id' => 'level',
			'placeholder' => trans('lingos::general.description')
		]
	) }}

	{{ Bootstrap::text(
		'level',
		trans('lingos::role.level'),
		null,
		$errors,
		'signal fa-fw',
		[
			'id' => 'level',
			'placeholder' => trans('lingos::role.level')
		]
	) }}

	{{ Bootstrap::checkbox(
		'active',
		trans('lingos::general.active'),
		null
	) }}

	<hr>

	{{ Bootstrap::submit(
		trans('lingos::button.save'),
		[
			'class' => 'btn btn-success btn-block'
		]
	) }}

	<div class="row">
		<div class="col-sm-6">
		{{ Bootstrap::linkIcon(
			'roles.index',
			trans('lingos::button.cancel'),
			'times fa-fw',
			[
				'class' => 'btn btn-default btn-block'
			]
		) }}
		</div>
		<div class="col-sm-6">
		{{ Bootstrap::reset(
			trans('lingos::button.reset'),
			[
				'class' => 'btn btn-default btn-block'
			]
		) }}
		</div>
	</div>


{{ Form::close() }}
</div>
@stop

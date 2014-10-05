@extends(Config::get('vedette.vedette_views.layout'))

@section('title')
@parent
	{{ Config::get('vedette.vedette_html.separator') }}
	{{ trans('lingos::role.command.edit') }}
@stop

@section('styles')
@stop

@section('scripts')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>
@stop

@section('inline-scripts')
	var text_confirm_message = '{{ trans('lingos::role.ask.delete') }}';
@stop

@section('content')
<div class="row">
<h1>
	<p class="pull-right">
	{{ Bootstrap::linkIcon(
		'admin.roles.index',
		trans('lingos::button.back'),
		'chevron-left fa-fw',
		array('class' => 'btn btn-default')
	) }}
	</p>
	<i class="fa fa-edit fa-lg"></i>
	{{ trans('lingos::role.command.edit') }}
	<hr>
</h1>
</div>


<div class="row">

{{ $message = Session::get('message') }}

{{ Form::open(
	[
		'route' => array('admin.roles.update', $role->id),
		'role' => 'form',
		'method' => 'put'
	]
) }}
{{ Form::hidden('role', $role->id) }}


	{{ Bootstrap::text(
		'name',
		null,
		$role->name,
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
		'level',
		null,
		$role->level,
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
		1,
		$role->active
	) }}

	<hr>

	{{ Bootstrap::submit(
		trans('lingos::button.save'),
		[
			'class' => 'btn btn-success btn-block'
		]
	) }}

	<div class="row">
		<div class="col-sm-4">
		{{ Bootstrap::linkIcon(
			'admin.roles.index',
			trans('lingos::button.cancel'),
			'times fa-fw',
			[
				'class' => 'btn btn-default btn-block'
			]
		) }}
		</div>
		<div class="col-sm-4">
		{{ Bootstrap::reset(
			trans('lingos::button.reset'),
			[
				'class' => 'btn btn-default btn-block'
			]
		) }}
		</div>
		<div class="col-sm-4">
		{{ Bootstrap::linkIcon(
			'admin.users.destroy',
			trans('lingos::button.delete'),
			'trash-o fa-fw',
			array(
				'class' => 'btn btn-default btn-block action_confirm',
				'data-method' => 'delete',
				'title' => trans('lingos::account.command.delete')
			)
		) }}
		</div>
	</div>

{{ Form::close() }}

</div>
@stop

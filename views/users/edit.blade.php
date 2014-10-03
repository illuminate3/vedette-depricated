@extends(Config::get('vedette.vedette_views.layout'))

@section('title')
@parent
	{{ Config::get('vedette.vedette_html.separator') }}
	{{ trans('lingos::account.command.edit') }}
@stop

@section('styles')
@stop

@section('scripts')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>
@stop

@section('inline-scripts')
	var text_confirm_message = '{{ trans('lingos::account.ask.delete') }}';
@stop

@section('content')
<div class="row">
<h1>
	@if (Auth::check())
		<p class="pull-right">
		{{ Bootstrap::linkIcon(
			'admin.index',
			trans('lingos::button.back'),
			'chevron-left fa-fw',
			array('class' => 'btn btn-default')
		) }}
		</p>
	@endif
	<i class="fa fa-edit fa-lg"></i>
	{{ trans('lingos::account.command.edit') }}
	<hr>
</h1>
</div>


<div class="row">

{{ $message = Session::get('message') }}

{{ Form::open(
	[
		'route' => array('admin.users.update', $user->id),
		'role' => 'form',
		'method' => 'put'
	]
) }}
{{ Form::hidden('user', $user->id) }}


	{{ Bootstrap::email(
		'email',
		null,
		$user->email,
		$errors,
		'envelope fa-fw',
		[
			'id' => 'email',
			'placeholder' => trans('lingos::account.email'),
			'required',
			'autofocus'
		]
	) }}

	{{ Bootstrap::password(
		'password',
		null,
		$errors,
		'unlock fa-fw',
		[
			'id' => 'password',
			'placeholder' => trans('lingos::auth.password'),
			'required'
		]
	) }}

	{{ Bootstrap::password(
		'password_confirmation',
		null,
		$errors,
		'unlock-alt fa-fw',
		[
			'id' => 'password',
			'placeholder' => trans('lingos::auth.confirm_password'),
			'required',
			'autocomplete' => 'off'
		]
	) }}


	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
					<i class="fa fa-gavel fa-fw"></i>
				{{ trans('lingos::role.roles') }}
			</h3>
		</div>
		<div class="panel-body">
		@foreach (Vedette\models\Role::All() as $role)
			{{ Bootstrap::checkbox('roles[]', $role->present()->name(), $role->id, $user->hasRole($role->id)) }}
		@endforeach
		</div>
	</div>

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
			'admin.users.index',
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

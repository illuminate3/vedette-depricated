@extends(Config::get('vedette.vedette_views.layout'))

@section('title')
@parent
	{{  Config::get('vedette.vedette_config.separator') }}
	{{ trans('lingos::account.command.create') }}
@stop

@section('styles')
@stop

@section('scripts')
@stop

@section('inline-scripts')
@stop

@section('content')
<div class="row">
<h1>
	@if (Auth::check())
		<p class="pull-right">
		{{ Bootstrap::linkIcon(
			'admin.index',
			trans('lingos::button.back'),
			'fa-chevron-left fa-fw',
			array('class' => 'btn btn-default')
		) }}
		</p>
	@endif
	<i class="fa fa-group fa-lg"></i>
	{{ trans('lingos::account.command.create') }}
	<hr>
</h1>
</div>


<div class="row">

	{{ Form::open(array(
		'route' => 'admin.users.store',
		'role' => 'form'
	)) }}



	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#info" data-toggle="tab">
				<i class="fa fa-user fa-fw"></i>
				{{ trans('lingos::general.information') }}
			</a>
		</li>
		<li>
			<a href="#password" data-toggle="tab">
				{{ trans('lingos::auth.password') }}
			</a>
		</li>
		<li>
			<a href="#status" data-toggle="tab">
				{{ trans('lingos::general.status') }}
			</a>
		</li>
	</ul>

	<div id="myTabContent" class="tab-content">
	<div class="tab-pane active in padding-lg" id="info">

		<fieldset>
			<h2>
				<legend>
					<i class="fa fa-user fa-fw"></i>
					{{ trans('lingos::general.personal_information') }}
				</legend>
			</h2>


		</fieldset>

		<fieldset>
			<h2>
				<legend><i class="fa fa-envelope-o fa-fw"></i>{{ trans('lingos::general.email') }}</legend>
			</h2>

		</fieldset>

	</div><!-- tab-info -->
	</div><!-- tab-info -->


		{{ Bootstrap::email(
			'email',
			'Email address',
			null,
			$errors,
			'fa-envelope fa-fw'
		) }}


		{{ Bootstrap::password(
			'password',
			'Password',
			$errors,
			'fa-unlock fa-fw'
		) }}


		{{ Bootstrap::password(
			'password_confirmation',
			'Password confirmation',
			$errors,
			'fa-unlock-alt fa-fw'
		) }}

		<h5><strong>Roles</strong></h5>
		@foreach (Vedette\models\Role::All() as $role)
			{{ Bootstrap::checkbox('roles[]', $role->present()->name(), $role->id) }}
		@endforeach

		{{ Bootstrap::linkRoute('admin.index', 'Back') }}
		{{ Bootstrap::submit('Save') }}

	{{ Form::close() }}

</div>
@stop

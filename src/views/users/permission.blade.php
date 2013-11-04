@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
@stop

@section('page_title')
	- {{ Lang::get('lingos::sentry.users_permissions') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-wrench fa-lg"></i>
		{{ Lang::get('lingos::sentry.users_permissions') }}
	</h1>
@stop

@section('content')

@if (Sentry::check())

<div class="row">
<div class="row btn-toolbar pull-right" role="toolbar">
	<a href="{{ route('auth.users.index') }}" class="btn btn-info" title="{{ Lang::get('lingos::general.back') }}">
		<i class="fa fa-backward"></i>
		{{ Lang::get('lingos::general.back') }}
	</a>
</div>
</div>

<div class="row">
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#generics" data-toggle="tab">
				{{ Lang::get('lingos::sentry.generic_permissions') }}
			</a>
		</li>
		<li>
			<a href="#modules" data-toggle="tab">
				{{ Lang::get('lingos::sentry.modules_permissions') }}
			</a>
		</li>
	</ul>

{{ Former::horizontal_open( route('auth.users.permissions', array($user->id)), 'POST' ) }}

<div id="myTabContent" class="tab-content">

<div class="tab-pane active in padding-lg" id="generics">

	<fieldset>
		<legend>
			<i class="fa fa-gavel"></i>
			{{ Lang::get('lingos::sentry.access_everything') }}
		</legend>
	<table class="table table-striped table-hover">
		<tbody>
			<tr>
				<td class="padding-left-lg">
					{{ Former::select('rules[superuser]', Lang::get('lingos::general.super_user') )
						->options(array('0' => Lang::get('lingos::general.no'),'1' => Lang::get('lingos::general.yes') ))
						->value($user->isSuperUser() ? 1 : 0)
						->class('margin-left')
					}}
					@foreach( $genericPerm as $perm)
				</td>
			</tr>
		</tbody>
	</table>
	</fieldset>

	<fieldset>
		<legend>
			<i class="fa fa-filter"></i>
			{{ Lang::get('lingos::sentry.generic_permissions') }}
		</legend>
	<table class="table table-striped table-hover">
		<tbody>
			@foreach( $perm['permissions'] as $input )
			<tr>
				<td class="padding-left-lg">
					{{ Former::select($input['name'],$input['text'])
						->options(array('0' => Lang::get('lingos::sentry.inherit'),'1' => Lang::get('lingos::sentry.allow'),'-1' => Lang::get('lingos::sentry.deny')))
						->value($input['value'])
						->class('margin-left')
						->id($input['id'])
					}}
				</td>
			</tr>
			@endforeach
			@endforeach
		</tbody>
	</table>
	</fieldset>

</div>
<div class="tab-pane fade padding-lg" id="modules">

	@if (count($modulePerm) < 1)
		<div class="alert alert-warning">
			{{ Lang::get('lingos::sentry.permission_module_not_found') }}
		</div>
	@else
	<table class="table table-striped table-hover">
		<tbody>
		@foreach( $modulePerm as $perm)
			<tr>
				<td>
					{{ $perm['name'] }} {{ Lang::get('lingos::general.module') }}
				</td>
			</tr>
			<tr>
				<td class="padding-left-lg">
					@foreach( $perm['permissions'] as $input )
						{{ Former::select($input['name'],$input['text'])
							->options(array('0' => Lang::get('lingos::sentry.inherit'),'1' => Lang::get('lingos::sentry.allow'),'-1' => Lang::get('lingos::sentry.deny')))
							->value($input['value'])
							->class('margin-left')
							->id($input['id'])
						}}
					@endforeach
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	@endif

</div>

	<hr>

		{{ Former::actions()
			->success_submit(Lang::get('lingos::button.save_changes'))
			->inverse_reset(Lang::get('lingos::button.reset'))
		}}

{{ Former::close() }}

</div>
</div>

<div class="row btn-toolbar margin-top" role="toolbar">
	<a href="{{ URL::to('users/delete') }}/{{ $user->id}}"
	class="btn btn-danger action_confirm"
	data-method="post"
	title="{{ Lang::get('lingos::general.delete_user') }}">
		<i class="fa fa-trash-o"></i>
		{{ Lang::get('lingos::general.delete_user') }}
	</a>
</div>

@else
	<div class="alert alert-warning">
		<h2>
			{{ Lang::get('lingos::auth.insufficient_permissions') }}
		</h2>
	</div>
@endif

@stop

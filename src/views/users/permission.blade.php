@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ Lang::get('lingos::sentry.ask.delete_user') }}';
		$(document).ready(function() {
			$('.js-activated').dropdownHover().dropdown();
		});
	</script>
@stop

@section('page_title')
	- {{ Lang::get('lingos::sentry.users_permissions') }}
@stop

@section('title')
	<i class="fa fa-wrench fa-lg"></i>
	{{ Lang::get('lingos::sentry.users_permissions') }}
@stop

@section('content')
@if (Sentry::check())

	<div class="row">
	<div class="row btn-toolbar pull-right" role="toolbar">
		<a href="{{ route('auth.users.index') }}" class="btn btn-info" title="{{ Lang::get('lingos::button.back') }}">
			<i class="fa fa-backward"></i>
			{{ Lang::get('lingos::button.back') }}
		</a>
	</div>
	</div>

	<div class="row">
	{{ Former::horizontal_open( route('auth.users.permissions', array($user->id)), 'POST' ) }}

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

	<div id="myTabContent" class="tab-content">

	<div class="tab-pane active in padding-lg" id="generics">

		<br>

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

		<br>

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

	</div>

	<hr>

	<div class="row btn-toolbar" role="toolbar">
		<div class="col-xs-6 col-md-4">
			<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ Lang::get('lingos::button.save_changes') }}">
			<div>
				<br>
			</div>
			<input class="btn-inverse btn" type="reset" value="{{ Lang::get('lingos::button.reset') }}">
			<a class="btn btn-warning" href="{{ URL::route('home') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
			<a href="{{ URL::to('users/delete') }}/{{ $user->id}}"
			class="btn btn-danger action_confirm"
			data-method="post"
			title="{{ Lang::get('lingos::button.user.delete') }}">
				<i class="fa fa-trash-o"></i>
				{{ Lang::get('lingos::button.user.delete') }}
			</a>
		</div>
	</div>

	{{ Former::close() }}
	</div>

@else
	<div class="alert alert-warning">
		<h2>
			{{ Lang::get('lingos::sentry.permission_error.insufficient') }}
		</h2>
	</div>
@endif
@stop

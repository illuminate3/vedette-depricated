@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ trans('lingos::sentry.ask.delete_group') }}';
	</script>
@stop

@section('page_title')
	- {{ trans('lingos::sentry.group_permissions') }}
@stop

@section('title')
	<i class="fa fa-wrench fa-lg"></i>
	{{ trans('lingos::sentry.group_permissions') }}
@stop

@section('content')
@if (Sentry::check())

	<div class="row">
	<div class="row btn-toolbar pull-right" role="toolbar">
		<a href="{{ route('auth.groups.index') }}" class="btn btn-info" title="{{ trans('lingos::button.back') }}">
			<i class="fa fa-backward"></i>
			{{ trans('lingos::button.back') }}
		</a>
	</div>
	</div>

	<div class="row">
	{{ Former::horizontal_open( route('auth.groups.permissions', array($group->id)), 'PUT' ) }}

		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#generics" data-toggle="tab">
					{{ trans('lingos::sentry.generic_permissions') }}
				</a>
			</li>
			<li>
				<a href="#modules" data-toggle="tab">
					{{ trans('lingos::sentry.modules_permissions') }}
				</a>
			</li>
		</ul>

	<div id="myTabContent" class="tab-content">

	<div class="tab-pane active in padding-lg" id="generics">

		<br>

		<fieldset>
			<legend>
				<i class="fa fa-filter"></i>
				{{ trans('lingos::sentry.generic_permissions') }}
			</legend>
		<table class="table table-striped table-hover">
			<tbody>
				<tr>
					<td class="padding-left-lg">
						@foreach( $genericPerm as $perm)
							@foreach( $perm['permissions'] as $input )
								{{ Former::select($input['name'],$input['text'])
									->options(array('0' => trans('lingos::sentry.deny'), '1' => trans('lingos::sentry.allow') ))
									->value($input['value'])
									->class('margin-left')
									->id($input['id'])
								}}
							@endforeach
						@endforeach
					</td>
				</tr>
			</tbody>
		</table>
		</fieldset>

	</div>
	<div class="tab-pane fade padding-lg" id="modules">

		<br>

		@if (count($modulePerm) < 1)
			<div class="alert alert-warning">
				{{ trans('lingos::sentry.permission_module_not_found') }}
			</div>
		@else
		<table class="table table-striped table-hover">
			<tbody>
			@foreach( $modulePerm as $perm)
				<tr>
					<td>
						{{ $perm['name'] }} {{ trans('lingos::general.module') }}
					</td>
				</tr>
				<tr>
					<td class="padding-left-lg">
						@foreach( $perm['permissions'] as $input )
							{{ Former::select($input['name'],$input['text'])
								->options(array('0' => trans('lingos::sentry.inherit'),'1' => trans('lingos::sentry.allow'),'-1' => trans('lingos::sentry.deny')))
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
			<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ trans('lingos::button.save_changes') }}">
			<div>
				<br>
			</div>
			<input class="btn-inverse btn" type="reset" value="{{ trans('lingos::button.reset') }}">
			<a class="btn btn-warning" href="{{ route('auth.groups.index') }}"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
			<a href="{{ route('auth.groups.destroy', array($group->id)) }}"
				class="btn btn-danger action_confirm"
				data-method="delete"
				title="{{ trans('lingos::button.group.delete') }}">
				<i class="fa fa-trash-o"></i>
				{{ trans('lingos::button.group.delete') }}
			</a>
		</div>
	</div>

	{{ Former::close() }}
	</div>

@else
	<div class="alert alert-warning">
		<h2>
			{{ trans('lingos::sentry.permission_error.insufficient') }}
		</h2>
	</div>
@endif
@stop

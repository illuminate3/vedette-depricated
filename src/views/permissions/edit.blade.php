@extends(Config::get('vedette::vedette_views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ trans('lingos::sentry.ask.delete_permission') }}';
	</script>
@stop

@section('page_title')
	- {{ trans('lingos::sentry.permission_command.edit') }}
@stop

@section('title')
	<i class="fa fa-pencil-square-o fa-lg"></i>
	{{ trans('lingos::sentry.permission_command.edit') }}
@stop

@section('content')
@if (Sentry::check())

	<div class="row">
	<div class="row btn-toolbar pull-right" role="toolbar">
		<a href="{{ route('auth.permissions.index') }}" class="btn btn-info" title="{{ trans('lingos::button.back') }}">
			<i class="fa fa-backward"></i>
			{{ trans('lingos::button.back') }}
		</a>
	</div>
	</div>

	<br>

	<div class="row">
	{{ Former::horizontal_open(route('auth.permissions.update', array($permission->id)))->method('PUT') }}

	{{ Former::text('name', '', $permission->name)
		->prepend('<i class="fa fa-building"></i>')
		->class('form-control has-error')
		->id('name')
		->placeholder(trans('lingos::sentry.module'))
		->autofocus()
	}}

	<br>

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">{{ trans('lingos::sentry.generic_permissions') }}</h3>
		</div>
		<div class="panel-body">
			<div class="padding-left">
				@foreach ($roles['inputs'] as $key => $value)
					<label class="checkbox">
						<input type="checkbox" name="permissions[{{$key}}]"
						value="{{$key}}" {{ in_array($key, $permission->rules) ? 'checked="checked"' : '' }}>
						{{ ucfirst($key) }}
					</label>
				@endforeach
			</div>
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
			<a class="btn btn-warning" href="{{ URL::route('auth.permissions.index') }}"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
			<a href="{{ route('auth.permissions.destroy', array($permission->id)) }}"
				class="btn btn-danger action_confirm"
				data-method="delete"
				title="{{ trans('lingos::button.permission.delete') }}">
				<i class="fa fa-trash-o"></i>
				{{ trans('lingos::button.permission.delete') }}
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

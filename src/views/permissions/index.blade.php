@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ Lang::get('lingos::sentry.ask.delete_permission') }}';
	</script>
@stop

@section('page_title')
	- {{ Lang::get('lingos::sentry.permissions') }}
@stop

@section('title')
	<i class="fa fa-wrench fa-lg"></i>
	{{ Lang::get('lingos::sentry.permissions') }}
@stop

@section('content')

@if (Sentry::check())

<div class="panel panel-info">
	<div class="panel-heading">
		<h3 class="panel-title">{{ Lang::get('lingos::sentry.generic_permissions') }}</h3>
	</div>
	<div class="panel-body">
		<ul>
			@foreach ($roles['inputs'] as $role => $value)
				<li>{{ ucfirst($role) }}</li>
			@endforeach
		</ul>
	</div>
</div>

@if($permissions->isEmpty())
	<div class="alert alert-warning margin-top">
		{{ Lang::get('lingos::sentry.permission_module_not_found') }}
	</div>
@else

	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">{{ Lang::get('lingos::sentry.generic_permissions') }}</h3>
		</div>
		<div class="panel-body">

			<div class="row btn-toolbar pull-right margin-right" role="toolbar">
				<a href="{{ route('auth.permissions.create') }}" class="btn btn-success" title="{{ Lang::get('lingos::button.permission.new') }}">
					<i class="fa fa-plus-circle"></i>
					{{ Lang::get('lingos::button.permission.new') }}
				</a>
			</div>

			<table class="table table-striped table-hover">
				<thead>
					<tr>
					<th>{{ Lang::get('lingos::table.module') }}</th>
					<th>{{ Lang::get('lingos::table.role') }}</th>
					<th>{{ Lang::get('lingos::table.action') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($permissions->all() as $permission)
					<tr>
						<td>
							{{ $permission->name }}
						</td>
						<td>
							<ul>
								@foreach ($permission->permissions as $role)
									<li>{{ $role }}</li>
								@endforeach
							</ul>
						</td>
						<td>
							<a href="{{ route('auth.permissions.edit', array($permission->id)) }}"
								class="btn btn-primary" title="{{ Lang::get('lingos::button.permission.edit') }}">
								<i class="fa fa-pencil"></i>
								{{ Lang::get('lingos::button.permission.edit') }}
							</a>
							<a href="{{ route('auth.permissions.destroy', array($permission->id)) }}"
								class="btn btn-danger action_confirm"
								data-method="post"
								title="{{ Lang::get('lingos::button.permission.delete') }}">
								<i class="fa fa-trash-o"></i>
								{{ Lang::get('lingos::button.permission.delete') }}
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</div>

@endif

@else
	<div class="alert alert-warning">
		<h2>
			{{ Lang::get('lingos::sentry.permission_error.insufficient') }}
		</h2>
	</div>
@endif

@stop

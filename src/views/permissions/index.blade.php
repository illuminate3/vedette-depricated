@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ Lang::get('lingos::sentry.ask_delete_permission') }}';
	</script>
@stop

@section('page_title')
	- {{ Lang::get('lingos::sentry.permissions') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-wrench fa-lg"></i>
		{{ Lang::get('lingos::sentry.permissions') }}
	</h1>
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
				<a href="{{ route('auth.permissions.create') }}" class="btn btn-success" title="{{ Lang::get('lingos::sentry.new_permission') }}">
					<i class="fa fa-plus-circle"></i>
					{{ Lang::get('lingos::sentry.new_permission') }}
				</a>
			</div>

			<table class="table table-striped table-hover">
				<thead>
					<tr>
					<th>{{ Lang::get('lingos::general.module') }}</th>
					<th>{{ Lang::get('lingos::general.role') }}</th>
					<th>{{ Lang::get('lingos::general.action') }}</th>
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
								class="btn btn-warning" title="{{ Lang::get('lingos::sentry.edit_permissions') }}">
								<i class="fa fa-pencil"></i>
								{{ Lang::get('lingos::sentry.edit_permissions') }}
							</a>
							<a href="{{ route('auth.permissions.destroy', array($permission->id)) }}"
								class="btn btn-danger action_confirm"
								data-method="post"
								title="{{ Lang::get('lingos::general.delete_user') }}">
								<i class="fa fa-trash-o"></i>
								{{ Lang::get('lingos::sentry.delete_permission') }}
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
			{{ Lang::get('lingos::auth.insufficient_permissions') }}
		</h2>
	</div>
@endif

@stop

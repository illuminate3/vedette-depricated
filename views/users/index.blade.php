@extends(Config::get('vedette.vedette_views.layout'))

@section('title')
@parent
	{{ Config::get('vedette.vedette_html.separator') }}
	{{ trans('lingos::account.users') }}
@stop

@section('styles')
	<link rel="stylesheet" href="{{ asset('packages/illuminate3/vedette/assets/vendors/Datatables-Bootstrap3/BS3/assets/css/datatables.css') }}">
@stop

@section('scripts')
	<script src="{{ asset('packages/illuminate3/vedette/assets/vendors/DataTables/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('packages/illuminate3/vedette/assets/vendors/Datatables-Bootstrap3/BS3/assets/js/datatables.js') }}"></script>
@stop

@section('inline-scripts')
$(document).ready(function() {

	var text_confirm_message = '{{ trans('lingos::account.ask.delete') }}';

	$('#DataTable').dataTable({
		stateSave: true
	});
	$('#DataTable').each(function(){
		var datatable = $(this);
		var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
		search_input.attr('placeholder', 'Search');
		search_input.addClass('form-control input-sm');
		var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
		length_sel.addClass('form-control input-sm');
	});

});
@stop

@section('content')
<div class="row">
<h1>
	@if (Auth::check())
		<p class="pull-right">
		@if (Auth::user()->hasRoleWithName('Admin'))
			{{ Bootstrap::linkIcon(
				'admin.users.create',
				trans('lingos::button.user.new'),
				'plus fa-fw',
				array('class' => 'btn btn-info')
			) }}
		@endif
		{{ Bootstrap::linkIcon(
			'admin.index',
			trans('lingos::button.back'),
			'chevron-left fa-fw',
			array('class' => 'btn btn-default')
		) }}
		</p>
	@endif
	<i class="fa fa-group fa-lg"></i>
	{{ trans('lingos::account.users') }}
	<hr>
</h1>
</div>

<div class="row">
@if (count($users))

<div class="table-responsive">
<table class="table table-striped table-hover" id="DataTable">
			<thead>
			<tr>
				<th>#</th>
				<th>{{ trans('lingos::table.name') }}</th>
				<th>{{ trans('lingos::table.email') }}</th>
				<th>{{ trans('lingos::table.roles') }}</th>
				<th>{{ trans('lingos::table.actions') }}</th>
			</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
					<tr>
						<td>{{ $user->id }}</td>
						<td>{{ $user->present()->name() }}</td>
						<td>{{ $user->present()->email() }}</td>
						<td>{{ $user->present()->roles() }}</td>
						<td width="20%">
							{{ Form::open(array(
								'route' => array('admin.users.destroy', $user->id),
								'role' => 'form',
								'method' => 'delete',
								'class' => 'form-inline'
							)) }}
		<a href="{{ route('admin.users.destroy', array($user->id)) }}"
		class="btn btn-danger action_confirm"
		data-method="delete"
		title="{{ trans('lingos::button.user.delete') }}">
			<i class="fa fa-trash-o"></i>
			{{ trans('lingos::button.user.delete') }}
		</a>

								{{ Bootstrap::linkRoute(
									'admin.users.edit',
									trans('lingos::button.user.edit'),
									array($user->id),
									array('class' => 'btn btn-success')
								) }}

								{{ Bootstrap::linkRoute(
									'admin.users.destroy',
									trans('lingos::button.user.edit'),
									array($user->id),
									array('class' => 'btn btn-success')
								) }}


							<a href="{{ route('admin.users.destroy', array($user->id)) }}"
								class="btn btn-danger"
								data-method="delete"
								onclick="{{ trans('lingos::account.command.delete') }}">
								<i class="fa fa-trash-o"></i>
								{{ trans('lingos::account.command.delete') }}--11
							</a>

								{{ Bootstrap::submit(
									trans('lingos::button.user.delete'),
									array(
										'class' => 'btn btn-danger',
									'onclick' => 'confirm(' . trans('lingos::account.command.delete') . ');'
									)
								) }}


<a href="{{ route('admin.users.destroy', $user->id) }}" onclick="if(!confirm('Are you sure to delete this item?')){return false;};" title="Delete this Item">
<i class="glyphicon glyphicon-trash"></i>
</a>


<a href="..." data-method="delete" data-confirm="Are you sure you want to delete?" rel="nofollow">Delete this entry</a>


							{{ Form::close() }}


<a class="btn btn-small btn-danger" href="#" data-toggle="modal" data-target=".delete-user-modal{{ $user->id }}">Delete</a>

<div class="modal fade delete-user-modal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h4 class="modal-title">Delete User</h4>
		</div>
		<div class="modal-body">
			<p>Delete the user: <strong>{{ $user->email }}</strong>?</p>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			&nbsp;
							{{ Form::open(array(
								'route' => array('admin.users.destroy', $user->id),
								'role' => 'form',
								'method' => 'delete',
								'class' => 'form-inline'
							)) }}
				{{ Form::submit('Delete', array('class' => 'btn btn-primary')) }}
			{{ Form::close() }}
		</div>
	</div>
</div>


						</td>
					</tr>
				@endforeach
			</tbody>
</table>
</div> <!-- ./responsive -->

@else
	{{ Bootstrap::info( trans('lingos::general.no_records'), true) }}
@endif

</div>
<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>
{{ Bootstrap::titleModal(
$user->id, 'myModal', 'title', 'admin.users.destroy', 'delete', 'close', 'button'
) }}
{{--
'id' => 'id',
'label' => 'label',
'title' => 'title',
'route' => ''route',
'method' => 'method',
'close' => 'close',
'button' => 'button'
--}}

@stop

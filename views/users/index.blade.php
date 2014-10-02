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
				'fa-plus fa-fw',
				array('class' => 'btn btn-info')
			) }}
		@endif
		{{ Bootstrap::linkIcon(
			'admin.index',
			trans('lingos::button.back'),
			'fa-chevron-left fa-fw',
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
							{{ Form::open(array('route' => array('admin.users.destroy', $user->id), 'role' => 'form', 'method' => 'delete', 'class' => 'form-inline')) }}
								{{ Bootstrap::linkRoute(
									'admin.users.edit',
									trans('lingos::button.user.edit'),
									array($user->id),
									array('class' => 'btn btn-success')
								) }}
								{{ Bootstrap::submit(
									trans('lingos::button.user.delete'),
									array('class' => 'btn btn-danger')
								) }}
							{{ Form::close() }}
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
@stop

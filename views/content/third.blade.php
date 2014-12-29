<h1>
	Dashboard
	<hr>
</h1>

<div class="row">
	<div class="col-md-2">
		<div class="panel panel-info">
			<div class="panel-heading">
			<h3 class="panel-title">
				Racks
			</h3>
			</div>
			<div class="panel-body">
				{{ $rack_count }}
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-info">
			<div class="panel-heading">
			<h3 class="panel-title">
				Pallets
			</h3>
			</div>
			<div class="panel-body">
				{{ $pallet_count }}
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-info">
			<div class="panel-heading">
			<h3 class="panel-title">
				Catalog
			</h3>
			</div>
			<div class="panel-body">
				{{ $catalog_count }}
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-info">
			<div class="panel-heading">
			<h3 class="panel-title">
				Items
			</h3>
			</div>
			<div class="panel-body">
				{{ $item_count }}
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-info">
			<div class="panel-heading">
			<h3 class="panel-title">
				Picks
			</h3>
			</div>
			<div class="panel-body">
				{{ $pick_count }}
			</div>
		</div>
	</div>
</div>

@if ($alerts->count())
<h2>
	Alerts
	<hr>
</h2>

@foreach ($alerts as $alert)
	@if ($alert->type = 1)
		<div class="alert alert-danger">
			{{{ $alert->message }}} : is out of stock
		</div>
	@else
		<div class="alert alert-success">
			{{{ $alert->message }}} : is in stock
		</div>
	@endif
@endforeach

{{--
<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Order_id</th>
				<th>Message</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($alerts as $alert)
				<tr>
					<td>{{{ $alert->order_id }}}</td>
					<td>{{{ $alert->message }}}</td>
					<td>{{ link_to_route('alerts.edit', 'Edit', array($alert->id), array('class' => 'btn btn-info')) }}</td>
					<td>
						{{ Form::open(array('method' => 'DELETE', 'route' => array('alerts.destroy', $alert->id))) }}
							{{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
						{{ Form::close() }}
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div> <!-- ./responsive -->
--}}
@else
	<div class="alert alert-info">
		There are no alerts
	</div>
@endif

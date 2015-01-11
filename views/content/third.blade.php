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
				<a href="{{ URL::to('racks') }}">{{ $rack_count }}</a>
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
				<a href="{{ URL::to('pallets') }}">{{ $pallet_count }}</a>
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
				<a href="{{ URL::to('catalogs') }}">{{ $catalog_count }}</a>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-info">
			<div class="panel-heading">
			<h3 class="panel-title">
				Global Items
			</h3>
			</div>
			<div class="panel-body">
				<a href="{{ URL::to('items') }}">{{ $item_count }}</a>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-2">
		<div class="panel panel-primary">
			<div class="panel-heading">
			<h3 class="panel-title">
				Customers
			</h3>
			</div>
			<div class="panel-body">
				<a href="{{ URL::to('customers') }}">{{ $customer_count }}</a>
			</div>
		</div>
	</div>
	<div class="col-md-2">
		<div class="panel panel-primary">
			<div class="panel-heading">
			<h3 class="panel-title">
				Customer Items
			</h3>
			</div>
			<div class="panel-body">
				<a href="{{ URL::to('customer_items') }}">{{{ $customer_item_count }}}</a>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-2">
		<div class="panel panel-success">
			<div class="panel-heading">
			<h3 class="panel-title">
				Picks
			</h3>
			</div>
			<div class="panel-body">
				<a href="{{ URL::to('picks') }}">{{ $pick_count }}</a>
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
			Customer ID: {{{ $alert->customer_id }}}
<br>
			Item: [ {{{ $alert->message }}} ]
			: Out of Stock
		</div>
	@else
		<div class="alert alert-success">
			Customer ID: {{{ $alert->customer_id }}}
<br>
			Item: [ {{{ $alert->message }}} ]
			: IN Stock
		</div>
	@endif
@endforeach

{{--
<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Order_id</th>
				<th>Customer_id</th>
				<th>Message</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($alerts as $alert)
				<tr>
					<td>{{{ $alert->order_id }}}</td>
					<td>{{{ $alert->customer_id }}}</td>
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

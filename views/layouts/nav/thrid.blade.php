<ul class="nav navbar-nav">
	<li {{ (strstr(Route::getCurrentRoute()->getPath(),'picks')) ? 'class="active"' : '' }} >
		<a href="{{ URL::to('picks') }}">Build Order</a>
	</li>
	<li {{ (strstr(Route::getCurrentRoute()->getPath(),'builds')) ? 'class="active"' : '' }} >
		<a href="{{ URL::to('builds') }}">Receiving</a>
	</li>
	<li {{ (strstr(Route::getCurrentRoute()->getPath(),'moves')) ? 'class="active"' : '' }} >
		<a href="{{ URL::to('moves') }}">Move Pallet</a>
	</li>
	<li {{ (strstr(Route::getCurrentRoute()->getPath(),'scans')) ? 'class="active"' : '' }} >
		<a href="{{ URL::to('scans') }}">Scans</a>
	</li>

	<li class="dropdown" id="accountmenu">
		<a class="dropdown-toggle " data-toggle="dropdown" href="#">
			Orders
			<i class="fa fa-chevron-down fa-fw"></i>
		</a>
		<ul class="dropdown-menu">
			<li>
				<a href="{{ URL::to('receiving') }}">Receiving</a>
			</li>
			<li>
				<a href="{{ URL::to('orders') }}">Shipping</a>
			</li>
		<li class="divider"></li>
			<li>
				<a href="{{ URL::to('bills') }}">Billing</a>
			</li>
		<li class="divider"></li>
			<li>
				<a href="{{ URL::to('invoices') }}">Invoices</a>
			</li>
		</ul>
	</li>
</ul>

@if (Auth::check())
@if (Auth::user()->hasRoleWithName('Admin'))

<li class="dropdown">
	<a class="dropdown-toggle {{ (Request::is('admin*') ? ' active' : '') }}" data-toggle="dropdown" href="#">
		Office
		<b class="caret"></b>
	</a>
	<ul class="dropdown-menu">
		<li>
			<a href="{{ URL::to('customers') }}">Customers</a>
		</li>
		<li>
			<a href="{{ URL::to('trucks') }}">Trucking</a>
		</li>
	<li class="divider"></li>
		<li>
			<a href="{{ URL::to('items') }}">Global Items</a>
		</li>
		<li>
			<a href="{{ URL::to('customer_items') }}">Customer Items</a>
		</li>
	<li class="divider"></li>
		<li>
			<a href="{{ URL::to('reports') }}">Reports</a>
		</li>
	<li class="divider"></li>
		<li>
			<a href="{{ URL::to('catalogs') }}">Catalog</a>
		</li>
		<li>
			<a href="{{ URL::to('racks') }}">Racks</a>
		</li>
		<li>
			<a href="{{ URL::to('pallets') }}">Pallets</a>
		</li>
	</ul>
</li>

<li class="dropdown">
	<a class="dropdown-toggle {{ (Request::is('admin*') ? ' active' : '') }}" data-toggle="dropdown" href="#">
		{{ trans('lingos::general.settings') }}
		<i class="fa fa-cogs fa-fw"></i>
	</a>
	<ul class="dropdown-menu">
		<li>
			<a href="{{ URL::to('allergens') }}">Allergens</a>
		</li>
		<li>
			<a href="{{ URL::to('zones') }}">Zones</a>
		</li>
		<li class="divider"></li>
		<li>
			<a href="{{ URL::to('statuses_billing') }}">Billing Statuses</a>
		</li>
		<li>
			<a href="{{ URL::to('statuses_paid') }}">Paid Statuses</a>
		</li>
		<li>
			<a href="{{ URL::to('statuses_sent') }}">Sent Statuses</a>
		</li>
		<li>
			<a href="{{ URL::to('statuses_receive') }}">Received Statuses</a>
		</li>
		<li>
			<a href="{{ URL::to('statuses_pick') }}">Pick Statuses</a>
		</li>
		<li class="divider"></li>
		<li>
			<a href="{{ URL::to('charge_types') }}">Charge Types</a>
		</li>
		<li>
			<a href="{{ URL::to('locale_types') }}">Locale Types</a>
		</li>
		</li>
	</ul>
</li>

@endif
@endif

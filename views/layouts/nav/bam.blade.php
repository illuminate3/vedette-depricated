<ul class="nav navbar-nav">

<li>
	<a href="{{ route('items.index') }}"><span class="glyphicon glyphicon-wrench"></span> Items</a>
</li>
<li>
	<a href="{{ route('asset.index') }}"><span class="glyphicon glyphicon-wrench"></span> Assets</a>
</li>
<li>
	<a href="{{ route('asset_statuses.index') }}"><span class="glyphicon glyphicon-wrench"></span> asset_statuses</a>
</li>
<li>
	<a href="{{ route('tech_statuses.index') }}"><span class="glyphicon glyphicon-wrench"></span> tech_statuses</a>
</li>
<li>
	<a href="{{ route('rooms.index') }}"><span class="glyphicon glyphicon-wrench"></span> Rooms</a>
</li>

<li>
	<a href="{{ route('categories.index') }}"><span class="glyphicon glyphicon-wrench"></span> Manage Categories</a>
</li>

</ul>

<li class="dropdown">
	<a class="dropdown-toggle {{ (Request::is('admin*') ? ' active' : '') }}" data-toggle="dropdown" href="#">
		HR
		<b class="caret"></b>
	</a>
	<ul class="dropdown-menu">
	<li {{ (strstr(Route::getCurrentRoute()->getPath(),'sites')) ? 'class="active"' : '' }} >
		{{ link_to('sites', 'Sites') }}
	</li>
	<li {{ (strstr(Route::getCurrentRoute()->getPath(),'profiles')) ? 'class="active"' : '' }} >
		{{ link_to('profiles', 'Staff') }}
	</li>
	</ul>
</li>

@if (Auth::check())
@if (Auth::user()->hasRoleWithName('Admin'))

<li class="dropdown">
	<a class="dropdown-toggle {{ (Request::is('admin*') ? ' active' : '') }}" data-toggle="dropdown" href="#">
		HR - {{ trans('lingos::general.settings') }}
		<b class="caret"></b>
	</a>
	<ul class="dropdown-menu">
		<li>
			{{ link_to('admin/departments', 'Departments') }}
		</li>
		<li>
			{{ link_to('admin/grades', 'Grades') }}
		</li>
		<li>
			{{ link_to('admin/divisions', 'Divisions') }}
		</li>
		<li>
			{{ link_to('admin/positions', 'Positions') }}
		</li>
		<li>
			{{ link_to('admin/subjects', 'Subjects') }}
		</li>
		<li>
			{{ link_to('admin/employee_types', 'Employee Types') }}
		</li>
		<li>
			{{ link_to('admin/job_titles', 'Job Titles') }}
		</li>
		<li class="divider"></li>
		<li>
			{{ link_to('admin/statuses', 'Statuses') }}
		</li>
	</ul>
</li>

@endif
@endif

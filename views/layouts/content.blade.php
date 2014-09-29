<div class="row-fuild">
	@if (Session::has('message'))
		{{ Session::get('message') }}
	@endif
</div>

@if (Auth::check())
	@if (Auth::user()->hasRoleWithName('Admin'))
	has role admin
	@endif
@endif

{{ trans('lingos::table.name') }}

@yield('content')

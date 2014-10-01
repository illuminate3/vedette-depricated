<div class="row-fuild">
	@if (Session::has('message'))
		{{ Session::get('message') }}
	@endif
</div>

@if (Auth::check())
	@if (Auth::user()->hasRoleWithName('Admin'))
	has role admin
	@endif
	@if (Auth::user()->hasRoleWithName('User'))
	has role User
	@endif
@endif

<br>
{{ trans('lingos::table.name') }}

@yield('content')

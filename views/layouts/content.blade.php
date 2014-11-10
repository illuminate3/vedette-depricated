<div class="row-fuild">
	@if (Session::has('message'))
		{{ Session::get('message') }}
	@endif
	{{ Session::get('success') }}
	@if (Session::has('success'))
		{{ Session::get('success') }}
	@endif
</div>

@yield('content')

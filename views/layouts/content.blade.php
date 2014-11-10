<div class="row-fuild">
	@if (Session::has('message'))
		<div class="alert alert-danger">
			{{ Session::get('message') }}
		</div>
	@endif
	{{ Session::get('success') }}
	@if (Session::has('success'))
		<div class="alert alert-success">
			{{ Session::get('success') }}
		</div>
	@endif
</div>

@yield('content')

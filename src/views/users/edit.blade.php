@extends(Config::get('vedette::views.layout'))

@section('css')
{{ HTML::style('assets/vendors/bootstrap-switch/stylesheets/bootstrap-switch.css') }}
@stop

@section('js')
	<script src="{{ asset('assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ Lang::get('lingos::general.ask_delete_user') }}';
	</script>
@stop

@section('page_title')
	- {{ Lang::get('lingos::general.edit_user') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-pencil fa-lg"></i>
		{{ Lang::get('lingos::general.edit_user') }}
		&nbsp;&quot;{{ $user->first_name }}&nbsp;{{ $user->last_name }}&quot;
	</h1>
@stop

@section('content')

@if (Sentry::check())

<div class="row btn-toolbar pull-right" role="toolbar">
	<a href="{{ route('auth.users.index') }}" class="btn btn-info" title="{{ Lang::get('lingos::general.back') }}">
		<i class="fa fa-backward"></i>
		{{ Lang::get('lingos::general.back') }}
	</a>
</div>

<div class="row">
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#info" data-toggle="tab">
				{{ Lang::get('lingos::general.information') }}
			</a>
		</li>
		<li>
			<a href="#password" data-toggle="tab">
				{{ Lang::get('lingos::auth.password') }}
			</a>
		</li>
		<li>
			<a href="#status" data-toggle="tab">
				{{ Lang::get('lingos::general.status') }}
			</a>
		</li>
	</ul>

{{ Former::horizontal_open( route('auth.users.update', array($user->id)), 'PUT' ) }}


<div id="myTabContent" class="tab-content">

<div class="tab-pane active in padding-lg" id="info">
	<fieldset>
		<legend><i class="fa fa-user"></i>{{ Lang::get('vedette::vedette.personal_information') }}</legend>
		{{ Former::text('first_name', '')
			->prepend('<i class="fa fa-check-circle"></i>')
			->class('form-control has-error')
			->id('first_name')
			->value($user->first_name)
			->placeholder(Lang::get('lingos::general.first_name'))
			->required()
			->autofocus()
		}}
		{{ Former::text('last_name', '')
			->prepend('<i class="fa fa-check-circle-o"></i>')
			->class('form-control has-error')
			->id('last_name')
			->value($user->last_name)
			->placeholder(Lang::get('lingos::general.last_name'))
			->required()
		}}
	</fieldset>

	<br>

	<fieldset>
		<legend><i class="fa fa-envelope-o"></i>{{ Lang::get('lingos::general.email') }}</legend>
		{{ Former::text('email', '')
			->prepend('<i class="fa fa-envelope-o"></i>')
			->class('form-control has-error')
			->id('email')
			->value($user->email)
			->placeholder(Lang::get('lingos::general.email'))
			->required()
		}}
	</fieldset>

</div>

<div class="tab-pane padding-lg" id="password">

	<fieldset>
		<legend>
			<i class="fa fa-key"></i>
			{{ Lang::get('lingos::auth.password') }}
			<span class="text-danger pull-right">
				<small>{{ Lang::get('vedette::vedette.leave_blank_keep_same') }}</small>
			</span>
		</legend>
		{{ Former::password('password', '')
			->prepend('<i class="fa fa-unlock-o"></i>')
			->class('form-control has-error')
			->id('password')
			->placeholder(Lang::get('lingos::auth.password'))
		}}
		{{ Former::password('confirm_password', '')
			->prepend('<i class="fa fa-unlock"></i>')
			->class('form-control has-error')
			->id('confirm_password')
			->placeholder(Lang::get('lingos::auth.confirm_password'))
		}}
	</fieldset>

</div>

<div class="tab-pane fade padding-lg" id="status">

	<fieldset>
		<legend><i class="fa fa-group"></i>{{ Lang::get('lingos::sentry.groups') }}</legend>
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-umbrella"></i></span>
			<select multiple class="form-control" id="groups" name="groups[]" multiple="true">
				@foreach($groups as $group)
					@if( in_array( $group->id, Input::old('groups', array())) or in_array($group->id, $userGroupsId) )
						<option selected="selected" value="{{ $group->id }}">{{ $group->name }}</option>
					@else
						<option value="{{ $group->id }}">{{ $group->name }}</option>
					@endif
				@endforeach
			</select>
		</div>
	</fieldset>

	<br>

	<fieldset>
		<legend><i class="fa fa-tachometer"></i>{{ Lang::get('lingos::sentry.suspension') }}</legend>
	<table class="table table-striped table-hover">
		<tbody>
			<tr>
				<td>{{ Lang::get('lingos::general.active') }}</td>
				<td>
					{{ Former::checkbox('activated', '')
						->id('activated')
						->check($user->activated)
					}}
				</td>
			</tr>
			<tr>
				<td>{{ Lang::get('lingos::sentry.banned') }}</td>
				<td>
					{{ Former::checkbox('banned', '')
						->id('banned')
						->check($throttles->banned)
					}}
				</td>
			</tr>
			<tr>
				<td>{{ Lang::get('lingos::sentry.suspended') }}</td>
				<td>
					{{ Former::checkbox('suspended', '')
						->id('suspended')
						->check($throttles->suspended)
					}}
				</td>
		</tbody>
	</table>
	</fieldset>

	<br>

	<fieldset>
		<legend><i class="fa fa-heart"></i>{{ Lang::get('lingos::general.activity') }}</legend>
	<table class="table table-striped table-hover">
		<tbody>
			<tr>
				<td>{{ Lang::get('lingos::general.date_activated') }}</td>
				<td>{{ $user->activated_at ? $user->activated_at : Lang::get('lingos::general.never_activated') }}</td>
			</tr>
			<tr>
				<td>{{ Lang::get('lingos::general.last_login') }}</td>
				<td>{{ is_null($user->last_login) ? Lang::get('lingos::general.never_visited') : $user->last_login }}</td>
			</tr>
		</tbody>
	</table>
	</fieldset>
</div>

</div>

	<hr>

	{{ Former::actions()
		->success_submit(Lang::get('lingos::button.save_changes'))
		->inverse_reset(Lang::get('lingos::button.reset'))
	}}

{{ Former::close() }}

</div>

<div class="row btn-toolbar margin-top" role="toolbar">
	<a href="{{ URL::to('users/delete') }}/{{ $user->id}}"
	class="btn btn-danger action_confirm"
	data-method="post"
	title="{{ Lang::get('lingos::general.delete_user') }}">
		<i class="fa fa-trash-o"></i>
		{{ Lang::get('lingos::general.delete_user') }}
	</a>
</div>

@else
	<div class="alert alert-warning">
		<h2>
			{{ Lang::get('lingos::auth.insufficient_permissions') }}
		</h2>
	</div>
@endif

@stop

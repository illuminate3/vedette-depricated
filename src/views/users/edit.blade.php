@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('assets/js/twitter-bootstrap-hover-dropdown.js') }}"></script>
	<script>
		$(document).ready(function() {

$('.row').tooltip({
	selector: "[data-toggle=tooltip]",
})

		});
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

@section('help')
	<p class="lead">{{ Lang::get('lingos::general.users') }}</p>
	<p>
		{{ Lang::get('vedette::vedette.help_user_edit') }}
	</p>
@stop

@section('content')

<div class="row">
<div class="row btn-toolbar pull-right" role="toolbar">
	<a href="{{ route('admin.users.index') }}" class="btn btn-info" rel="tooltip" title="{{ Lang::get('lingos::general.back') }}">
		<i class="fa fa-backward"></i>
		{{ Lang::get('lingos::general.back') }}
	</a>
</div>
</div>

<div class="row">
<div class="row btn-toolbar pull-right" role="toolbar">
	<a href="{{ route('admin.users.index') }}" class="btn btn-info" rel="tooltip" title="{{ Lang::get('lingos::general.back') }}">
		<i class="fa fa-backward"></i>
		{{ Lang::get('lingos::general.back') }}
	</a>
</div>
</div>

<div class="row">
<ul class="nav nav-tabs">
	<li class="active">
		<a href="#info" data-toggle="tab">
			{{ Lang::get('lingos::general.information') }}
		</a>
	</li>
	<li>
		<a href="#status" data-toggle="tab">
			{{ Lang::get('lingos::general.status') }}
		</a>
	</li>
</ul>
<div id="myTabContent" class="tab-content">
<div class="tab-pane active in padding-lg" id="info">

	<table class="table table-striped table-hover">
		<tbody>
			<tr>
				<td>{{ Lang::get('lingos::general.first_name') }}</td>
				<td>{{ $user->first_name }}</td>
			</tr>
			<tr>
				<td>{{ Lang::get('lingos::general.last_name') }}</td>
				<td>{{ $user->last_name }}</td>
			</tr>
			<tr>
				<td>{{ Lang::get('lingos::general.email') }}</td>
				<td>{{ $user->email }}</td>
			</tr>
		</tbody>
	</table>

</div>
<div class="tab-pane fade padding-lg" id="status">

	<table class="table table-striped table-hover">
		<tbody>
			<tr>
				<td>{{ Lang::get('lingos::sentry.groups') }}</td>
				<td>
					@foreach($user->groups as $group)
						{{ $group->getName() }}
					@endforeach
				</td>
			</tr>
			<tr>
				<td>{{ Lang::get('lingos::general.active') }}</td>
				<td>{{ ($user->activated) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}</td>
			</tr>
			<tr>
				<td>{{ Lang::get('lingos::sentry.banned') }}</td>
				<td>{{ ($throttles->banned) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}</td>
			</tr>
			<tr>
				<td>{{ Lang::get('lingos::sentry.suspended') }}</td>
				<td>{{ ($throttles->suspended) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}</td>
			<tr>
				<td>{{ Lang::get('lingos::general.date_activated') }}</td>
				<td>{{ $user->activated_at }}</td>
			</tr>
			<tr>
				<td>{{ Lang::get('lingos::general.last_login') }}</td>
				<td>{{ is_null($user->last_login) ? Lang::get('lingos::general.never_visited') : $user->last_login }}</td>
			</tr>
		</tbody>
	</table>

</div>
</div>




<div class="row">

{{ Former::horizontal_open()
	->id('form-users-edit')
	->secure()
	->rules(
		['first_name' => 'required'],
		['last_name' => 'required'],
		['email' => 'required']
	)
	->route('admin.users.update', array($user->id))
	->method('POST')
}}

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

	<br>

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

	<hr>

	<div class="margin-top">
		{{ Former::actions()
			->success_submit(Lang::get('lingos::button.save_changes'))
			->inverse_reset(Lang::get('lingos::button.reset'))
		}}
	</div>

	<div class="margin-top">
		<a class="btn btn-danger" href="{{ URL::route('admin.users.index') }}"><i class="fa fa-minus-circle"></i>{{ Lang::get('lingos::button.cancel') }}</a>
	</div>

{{ Former::close() }}

</div>

@stop

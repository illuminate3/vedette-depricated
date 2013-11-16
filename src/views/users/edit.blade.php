@extends(Config::get('vedette::vedette_views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('packages/illuminate3/vedette/assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ trans('lingos::sentry.ask.delete_user') }}';
	</script>
@stop

@section('page_title')
	- {{ trans('lingos::sentry.user_command.edit') }}
@stop

@section('title')
	<i class="fa fa-pencil fa-lg"></i>
	{{ trans('lingos::sentry.user_command.edit') }}
	&nbsp;&quot;{{ $user->first_name }}&nbsp;{{ $user->last_name }}&quot;
@stop

@section('content')
@if (Sentry::check())

	<div class="row">
	<div class="row btn-toolbar pull-right" role="toolbar">
		<a href="{{ route('auth.users.index') }}" class="btn btn-info" title="{{ trans('lingos::button.back') }}">
			<i class="fa fa-backward"></i>
			{{ trans('lingos::button.back') }}
		</a>
	</div>
	</div>

	<div class="row">
	{{ Former::horizontal_open( route('auth.users.update', array($user->id)), 'PUT' ) }}

		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#info" data-toggle="tab">
					{{ trans('lingos::general.information') }}
				</a>
			</li>
			<li>
				<a href="#password" data-toggle="tab">
					{{ trans('lingos::auth.password') }}
				</a>
			</li>
			<li>
				<a href="#status" data-toggle="tab">
					{{ trans('lingos::general.status') }}
				</a>
			</li>
		</ul>

	<div id="myTabContent" class="tab-content">

	<div class="tab-pane active in padding-lg" id="info">

		<br>

		<fieldset>
			<legend><i class="fa fa-user"></i>{{ trans('lingos::general.personal_information') }}</legend>
			{{ Former::text('first_name', '')
				->prepend('<i class="fa fa-check-circle"></i>')
				->class('form-control has-error')
				->id('first_name')
				->value($user->first_name)
				->placeholder(trans('lingos::general.first_name'))
				->required()
				->autofocus()
			}}
			{{ Former::text('last_name', '')
				->prepend('<i class="fa fa-check-circle-o"></i>')
				->class('form-control has-error')
				->id('last_name')
				->value($user->last_name)
				->placeholder(trans('lingos::general.last_name'))
				->required()
			}}
		</fieldset>

		<br>

		<fieldset>
			<legend><i class="fa fa-envelope-o"></i>{{ trans('lingos::general.email') }}</legend>
			{{ Former::text('email', '')
				->prepend('<i class="fa fa-envelope-o"></i>')
				->class('form-control has-error')
				->id('email')
				->value($user->email)
				->placeholder(trans('lingos::general.email'))
				->required()
			}}
		</fieldset>

	</div>

	<div class="tab-pane padding-lg" id="password">

		<br>

		<fieldset>
			<legend>
				<i class="fa fa-key"></i>
				{{ trans('lingos::auth.password') }}
				<span class="text-danger pull-right">
					<small>{{ trans('lingos::auth.leave_blank_keep_same') }}</small>
				</span>
			</legend>
			{{ Former::password('password', '')
				->prepend('<i class="fa fa-unlock-o"></i>')
				->class('form-control has-error')
				->id('password')
				->placeholder(trans('lingos::auth.password'))
			}}
			{{ Former::password('password_confirmation', '')
				->prepend('<i class="fa fa-unlock"></i>')
				->class('form-control has-error')
				->id('password_confirmation')
				->placeholder(trans('lingos::auth.confirm_password'))
			}}
		</fieldset>

	</div>

	<div class="tab-pane fade padding-lg" id="status">

		<br>

		<fieldset>
			<legend><i class="fa fa-group"></i>{{ trans('lingos::sentry.groups') }}</legend>
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
			<legend><i class="fa fa-tachometer"></i>{{ trans('lingos::sentry.suspension') }}</legend>
		<table class="table table-striped table-hover">
			<tbody>
				<tr>
					<td>{{ trans('lingos::general.active') }} {{ $user->activated }}</td>
					<td>
						{{ Former::checkbox('activated', '')
							->id('activated')
							->check($user->activated)
						}}
					</td>
				</tr>
				<tr>
					<td>{{ trans('lingos::sentry.banned') }}</td>
					<td>
						{{ Former::checkbox('banned', '')
							->id('banned')
							->check($throttles->banned)
						}}
					</td>
				</tr>
				<tr>
					<td>{{ trans('lingos::sentry.suspended') }}</td>
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
			<legend><i class="fa fa-heart"></i>{{ trans('lingos::general.activity') }}</legend>
		<table class="table table-striped table-hover">
			<tbody>
				<tr>
					<td>{{ trans('lingos::general.date_activated') }}</td>
					<td>{{ $user->activated_at ? $user->activated_at : trans('lingos::general.never_activated') }}</td>
				</tr>
				<tr>
					<td>{{ trans('lingos::general.last_login') }}</td>
					<td>{{ is_null($user->last_login) ? trans('lingos::general.never_visited') : $user->last_login }}</td>
				</tr>
			</tbody>
		</table>
		</fieldset>
	</div>

	</div>

	<hr>

	<div class="row btn-toolbar" role="toolbar">
		<div class="col-xs-6 col-md-4">
			<input class="btn btn-lg btn-success btn-block" type="submit" value="{{ trans('lingos::button.save_changes') }}">
			<div>
				<br>
			</div>
			<input class="btn-inverse btn" type="reset" value="{{ trans('lingos::button.reset') }}">
			<a class="btn btn-warning" href="{{ route('auth.users.index') }}"><i class="fa fa-minus-circle"></i>{{ trans('lingos::button.cancel') }}</a>
			<a href="{{ route('auth.users.destroy', array($user->id)) }}"
			class="btn btn-danger action_confirm"
			data-method="delete"
			title="{{ trans('lingos::button.user.delete') }}">
				<i class="fa fa-trash-o"></i>
				{{ trans('lingos::button.user.delete') }}
			</a>
		</div>
	</div>

	{{ Former::close() }}
	</div>

@else
	<div class="alert alert-warning">
		<h2>
			{{ trans('lingos::sentry.permission_error.insufficient') }}
		</h2>
	</div>
@endif
@stop

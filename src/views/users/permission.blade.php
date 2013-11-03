@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('js')
	<script src="{{ asset('assets/js/twitter-bootstrap-hover-dropdown.js') }}"></script>
	<script src="{{ asset('assets/js/restfulizer.js') }}"></script>
	<script>
		var text_confirm_message = '{{ Lang::get('lingos::general.ask_delete_user') }}';
		$(document).ready(function() {
			$('.js-activated').dropdownHover().dropdown();
		});
	</script>
@stop

@section('page_title')
	- {{ Lang::get('lingos::sentry.users_permissions') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-wrench fa-lg"></i>
		{{ Lang::get('lingos::sentry.users_permissions') }}
	</h1>
@stop

@section('content')

<div class="row">
<div class="row btn-toolbar pull-right" role="toolbar">
	<a href="{{ route('auth.users.index') }}" class="btn btn-info" title="{{ Lang::get('lingos::general.back') }}">
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
				<td>{{ Lang::get('lingos::general.date_activated') }}</td>
				<td>{{ $user->activated_at ? $user->activated_at : Lang::get('lingos::general.never_activated') }}</td>
			</tr>
			<tr>
				<td>{{ Lang::get('lingos::general.last_login') }}</td>
				<td>{{ is_null($user->last_login) ? Lang::get('lingos::general.never_visited') : $user->last_login }}</td>
			</tr>
		</tbody>
	</table>

</div>
</div>

</div>





    {{Former::horizontal_open( route('auth.users.permissions', array($user->id)), 'POST' )}}
    <div class="row">
        <div class="span12">
            <div class="block">
                <p class="block-heading">{{ $user->first_name }} {{ Lang::get('lingos::sentry.permissions') }} | {{ Lang::get('vedette::vedette.permissions_override_group_permissions') }}</p>
                <div class="block-body">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#generic" data-toggle="tab">{{ Lang::get('lingos::general.generic_permissions') }}</a></li>
                        <li><a href="#module" data-toggle="tab">{{ Lang::get('lingos::general.modules_permissions') }}</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="generic">
                            <legend>{{ Lang::get('lingos::general.super_user') }} <small>{{ Lang::get('vedette::vedette.access_everything') }}</small></legend>
                            {{ Former::select('rules[superuser]', Lang::get('lingos::general.super_user') )
                                ->options(array('0' => Lang::get('lingos::general.no'),'1' => Lang::get('lingos::general.yes') ))
                                ->value($user->isSuperUser() ? 1 : 0)
                                ->class('select2')
                            }}
                            @foreach( $genericPerm as $perm)
                                <legend>{{ Lang::get('lingos::general.generic_permissions') }}</legend>
                                @foreach( $perm['permissions'] as $input )
                                    {{ Former::select($input['name'],$input['text'])
                                        ->options(array('0' => Lang::get('lingos::sentry.inherit'),'1' => Lang::get('lingos::sentry.allow'),'-1' => Lang::get('lingos::sentry.deny')))
                                        ->value($input['value'])
                                        ->class('select2')->id($input['id'])
                                    }}
                                @endforeach
                            @endforeach
                        </div>
                        <div class="tab-pane" id="module">
                           @if (count($modulePerm) < 1)
                                <div class="alert alert-info">
                                    {{ Lang::get('lingos::sentry.no_found') }}
                                </div>
                            @else
                                @foreach( $modulePerm as $perm)
                                    <legend>{{ $perm['name'] }} {{ Lang::get('lingos::general.module') }}</legend>
                                    @foreach( $perm['permissions'] as $input )
                                        {{ Former::select($input['name'],$input['text'])
                                            ->options(array('0' => Lang::get('lingos::sentry.inherit'),'1' => Lang::get('lingos::sentry.allow'),'-1' => Lang::get('lingos::sentry.deny')))
                                            ->value($input['value'])
                                            ->class('select2')->id($input['id'])
                                        }}
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">{{ Lang::get('lingos::button.save_changes') }}</button>
                        <a href="{{route('auth.users.index')}}" class="btn">{{ Lang::get('lingos::button.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Former::close() }}
@stop

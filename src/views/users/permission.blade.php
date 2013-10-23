@extends(Config::get('vedette::views.layout'))

@section('header')
    <h3>
        <i class="icon-user"></i>
        {{ Lang::get('lingos::general.users_permissions') }}
    </h3>
@stop

@section('help')
    <p class="lead">{{ Lang::get('vedette::vedette.permission_inheritance') }}</p>
    <p>
        {{ Lang::get('vedette::vedette.help_user_permissions') }}
    </p>
    <br>
    <p class="text-warning">
        {{ Lang::get('vedette::vedette.permission_inheritance_only_users_permissions') }}
    </p>
     <p class="text-info">
        {{ Lang::get('lingos::general.visit_sentry_site') }}
    </p>
@stop

@section('content')
    {{Former::horizontal_open( route('admin.users.permissions', array($user->id)), 'PUT' )}}
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
                        <a href="{{route('admin.users.index')}}" class="btn">{{ Lang::get('lingos::button.cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Former::close() }}
@stop

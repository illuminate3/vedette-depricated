@extends(Config::get('vedette::views.layout'))

@section('header')
    <h3>
        <i class="icon-group"></i>
        {{ Lang::get('lingos::sentry.groups') }}
    </h3>
@stop
@section('help')
    <p class="lead">{{ Lang::get('lingos::sentry.permission_inheritance') }}</p>
    <p>
        {{ Lang::get('vedette::vedette.help_user_groups') }}
    </p>
    <br>
    <p class="text-warning">
        {{ Lang::get('lingos::sentry.inheritance_only_permissions') }}
    </p>
     <p class="text-info">
        {{ Lang::get('vedette::vedette.visit_sentry_site') }}
    </p>
@stop
@section('content')
    <div class="row">
        <div class="span12">
            {{ Former::horizontal_open(route('auth.groups.permissions', array($group->id)))->method('PUT') }}
            <div class="block">
                <p class="block-heading">{{$group->name}} {{ Lang::get('lingos::sentry.group_permissions') }}</p>
                <div class="block-body">

                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#generic" data-toggle="tab">{{ Lang::get('lingos::sentry.generic_permissions') }}</a></li>
                        <li><a href="#module" data-toggle="tab">{{ Lang::get('lingos::sentry.modules_permissions') }}</a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="generic">
                            @foreach( $genericPerm as $perm)
                                <legend>{{ Lang::get('lingos::sentry.generic_permissions') }}</legend>
                                @foreach( $perm['permissions'] as $input )
                                    {{ Former::select($input['name'],$input['text'])
                                        ->options(array('0' => Lang::get('lingos::sentry.deny'), '1' => Lang::get('lingos::sentry.allow') ))
                                        ->value($input['value'])
                                        ->class('select2')->id($input['id'])
                                    }}
                                @endforeach
                            @endforeach
                        </div>
                        <div class="tab-pane" id="module">
                            @if (count($modulePerm) < 1)
                                <div class="alert alert-info">
                                    {{ Lang::get('lingos::sentry.permission_module_not_found') }}
                                </div>
                            @else
                                @foreach( $modulePerm as $perm)
                                    <legend>{{ $perm['name'] }} {{ Lang::get('lingos::general.module') }}</legend>
                                    @foreach( $perm['permissions'] as $input )
                                        {{ Former::select($input['name'],$input['text'])
                                            ->options(array('0' => Lang::get('lingos::sentry.deny'), '1' => Lang::get('lingos::sentry.allow') ))
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
                        <a href="{{route('auth.groups.index')}}" class="btn">{{ Lang::get('lingos::button.cancel') }}</a>
                    </div>
                </div>
            </div>
            {{ Former::close() }}
        </div>
    </div>
@stop

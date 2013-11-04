@extends(Config::get('vedette::views.layout'))

@section('header')
    <h3>
        <i class="icon-group"></i>
        {{ Lang::get('lingos::sentry.groups') }}
    </h3>
@stop
@section('help')
    <p class="lead">{{ Lang::get('lingos::sentry.groups') }}</p>
    <p>
        {{ Lang::get('vedette::vedette.help_user_groups_index') }}
    </p>
    <br>
     <p class="text-info">
        {{ Lang::get('vedette::vedette.visit_sentry_site') }}
    </p>
@stop
@section('content')
    <div class="row">
        <div class="span12">
            <div class="block">
                <p class="block-heading">{{ Lang::get('lingos::sentry.groups') }}</p>
                <div class="block-body">
                    <div class="btn-toolbar">
                        <a href="{{ URL::route('auth.groups.create') }}" class="btn btn-primary" title="{{ Lang::get('lingos::sentry.create_new_group') }}">
                            <i class="icon-plus"></i>
                            {{ Lang::get('lingos::sentry.new_group') }}
                        </a>
                    </div>
                    @if (count($groups) == 0)
                        <div class="alert alert-info">
                            {{ Lang::get('vedette::groups.no_group') }}
                        </div>
                    @else
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>{{ Lang::get('lingos::general.name') }}</th>
                                <th class="span4"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($groups as $group)
                            <tr>
                                <td>{{ $group->name }}</td>
                                <td>
                                    <a href="{{ route('auth.groups.edit', array($group->id)) }}"
                                        class="btn" title="{{ Lang::get('lingos::sentry.edit_group') }}">
                                        <i class="icon-edit"></i>
                                    </a>
                                    <a href="{{ route('auth.groups.permissions', array($group->id)) }}"
                                        class="btn" title="{{ Lang::get('lingos::sentry.edit_group_permissions') }}">
                                        Permissions <i class="icon-arrow-right"></i>
                                    </a>
                                    <a href="{{ route('auth.groups.destroy', array($group->id)) }}"
                                        class="btn btn-danger" title="{{ Lang::get('lingos::sentry.delete_group') }}" data-method="delete"
                                        data-modal-text="{{ Lang::get('lingos::sentry.delete_group_confirm') }}">
                                        <i class="icon-remove"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>
@stop

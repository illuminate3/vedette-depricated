@extends(Config::get('vedette::views.layout'))

@section('header')
    <h3>
        <i class="icon-user"></i>
        {{ Lang::get('lingos::general.users') }}
    </h3>
@stop

@section('help')
    <p class="lead">{{ Lang::get('lingos::general.users') }}</p>
    <p>
        From here you can create, edit or delete users. Also you can assign custom permissions to a single user.
    </p>
@stop

@section('content')

    <div class="row">
        <div class="span12">

            <div class="block">
                <p class="block-heading">{{ Lang::get('lingos::general.users') }}</p>

                <div class="block-body">

                    <div class="btn-toolbar">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary" rel="tooltip" title="{{ Lang::get('vedette::vedette.create_new_user') }}">
                            <i class="icon-plus"></i>
                            {{ Lang::get('lingos::general.new_user') }}
                        </a>
                    </div>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ Lang::get('lingos::general.name') }}</th>
                                <th>{{ Lang::get('lingos::general.email') }}</th>
                                <th>{{ Lang::get('lingos::sentry.groups') }}</th>
                                <th>{{ Lang::get('lingos::general.active') }}</th>
                                <th>{{ Lang::get('lingos::general.joined') }}</th>
                                <th>{{ Lang::get('lingos::general.last_visit') }}</th>
                                <th>{{ Lang::get('lingos::general.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ HTML::linkRoute('admin.users.show',$user->first_name.' '.$user->last_name, array($user->id)) }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->groups as $group)
                                            <span class="label">{{ $group->getName() }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ ($user->activated) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}</td>
                                    <td>{{ $user->activated_at }}</td>
                                    <td>{{ is_null($user->last_login) ? Lang::get('lingos::general.never_visited') : $user->last_login }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                                                {{ Lang::get('lingos::general.action') }}
                                                <span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                               <li>
                                                   <a href="{{ route('admin.users.edit', array($user->id)) }}">
                                                       <i class="icon-edit"></i>&nbsp;{{ Lang::get('lingos::general.edit_user') }}
                                                   </a>
                                               </li>
                                                <li>
                                                    <a href="{{ route('admin.users.permissions', array($user->id)) }}">
                                                        <i class="icon-ban-circle"></i>&nbsp;{{ Lang::get('lingos::sentry.permissions') }}
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.users.destroy', array($user->id)) }}"
                                                       data-method="delete"
                                                       data-modal-text="{{ Lang::get('vedette::vedette.delete_user') }}">
                                                       <i class="icon-trash"></i>&nbsp;{{ Lang::get('lingos::general.delete_user') }}
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    @if ($user->isActivated())
                                                        <a href="{{ route('admin.users.deactivate', array($user->id)) }}"
                                                           data-method="put"
                                                           data-modal-text="{{ Lang::get('vedette::vedette.deactivate_user') }}">
                                                            <i class="icon-remove"></i>&nbsp;{{ Lang::get('lingos::general.deactivate') }}
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.users.activate', array($user->id)) }}"
                                                           data-method="put"
                                                           data-modal-text="{{ Lang::get('vedette::vedette.activate_user') }}">
                                                            <i class="icon-check"></i>&nbsp;{{ Lang::get('lingos::general.activate') }}
                                                        </a>
                                                    @endif
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{ route('admin.users.throttling', array($user->id)) }}">
                                                        <i class="icon-key"></i>&nbsp;{{ Lang::get('lingos::sentry.throttling') }}
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end of body -->

            </div> <!-- end of block -->

        </div>
    </div>

@stop

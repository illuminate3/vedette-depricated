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
        {{ Lang::get('vedette::vedette.help_user_show') }}
    </p>
@stop
@section('content')
    <div class="row">
        <div class="span12">

            <div class="block">
                <p class="block-heading">{{ $user->first_name }} {{ $user->last_name }} {{ Lang::get('lingos::general.profile') }}</p>

                <div class="block-body">

                    <div class="btn-toolbar">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-primary" rel="tooltip" title="{{ Lang::get('lingos::general.back') }}">
                            <i class="icon-arrow-left"></i>
                            {{ Lang::get('lingos::general.back') }}
                        </a>
                    </div>

                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td><strong>{{ Lang::get('lingos::general.first_name') }}</strong></td>
                                <td>{{ $user->first_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ Lang::get('lingos::general.last_name') }}</strong></td>
                                <td>{{ $user->last_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ Lang::get('lingos::general.email') }}</strong></td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ Lang::get('lingos::sentry.groups') }}</strong></td>
                                <td>
                                    @foreach($user->groups as $group)
                                        <span class="label">{{ $group->getName() }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td><strong>{{ Lang::get('lingos::general.activated') }}</strong></td>
                                <td>{{ ($user->activated) ? Lang::get('lingos::general.yes') : Lang::get('lingos::general.no') }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ Lang::get('lingos::general.date_activated') }}</strong></td>
                                <td>{{ $user->activated_at }}</td>
                            </tr>
                            <tr>
                                <td><strong>{{ Lang::get('lingos::general.last_login') }}</strong></td>
                                <td>{{ is_null($user->last_login) ? Lang::get('lingos::general.never_visited') : $user->last_login }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
@stop

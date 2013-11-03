@extends(Config::get('vedette::views.layout'))

@section('header')
<h3>
    <i class="icon-key"></i>
    {{ Lang::get('lingos::sentry.user_throttling') }}
</h3>
@stop

@section('help')
<p class="lead">{{ Lang::get('lingos::sentry.user_throttling') }}</p>
<p>
    {{ Lang::get('vedette::vedette.help_user_throttle') }}
</p>
@stop

@section('content')

<div class="row">
    <div class="span12">

        <div class="block">
            <p class="block-heading">{{ $user->first_name }}&nbsp; {{ $user->last_name }} {{ Lang::get('lingos::sentry.throttling_status') }}</p>

            <div class="block-body">

                @if ($throttle->isBanned())
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="{{ asset('packages/stevemo/vedette/img/not-ok-icon.png') }}" alt=""/>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">{{ Lang::get('lingos::sentry.banned') }}</h4>
                            <p>
                                <a href="{{ route('admin.users.throttling.update',array($user->id,'unban')) }}"
                                   class="btn btn-primary" title="{{ Lang::get('lingos::sentry.unban_user') }}"
                                   data-method="put" data-modal-text="{{ Lang::get('lingos::sentry.unban_user_confirm') }}">
                                    <i class="icon-check"></i>
                                    {{ Lang::get('lingos::sentry.unban') }}
                                </a>
                            </p>
                        </div>
                    </div>
                @else
                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="{{ asset('packages/stevemo/vedette/img/ok-icon.png') }}" alt=""/>
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading">{{ Lang::get('lingos::sentry.not_banned') }}</h4>
                            <p>
                                <a href="{{ route('admin.users.throttling.update',array($user->id,'ban')) }}"
                                   class="btn btn-danger" title="{{ Lang::get('lingos::sentry.ban_user') }}"
                                   data-method="put" data-modal-text="{{ Lang::get('lingos::sentry.ban_user_confirm') }}">
                                    <i class="icon-ban-circle"></i>
                                    {{ Lang::get('lingos::sentry.ban') }}
                                </a>
                            </p>
                        </div>
                    </div>
                @endif

                @if ($throttle->isSuspended())
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ asset('packages/stevemo/vedette/img/not-ok-icon.png') }}" alt=""/>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{ Lang::get('lingos::sentry.suspended') }}</h4>
                        <p>
                            <a href="{{ route('admin.users.throttling.update',array($user->id,'unsuspend')) }}"
                               class="btn btn-primary" title="{{ Lang::get('lingos::sentry.unban_ser') }}"
                               data-method="put" data-modal-text="{{ Lang::get('lingos::sentry.unsuspend_user_confirm') }}">
                                <i class="icon-check"></i>
                                {{ Lang::get('lingos::sentry.unsuspend_user') }}
                            </a>
                        </p>
                    </div>
                </div>
                @else
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="{{ asset('packages/stevemo/vedette/img/ok-icon.png') }}" alt=""/>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{ Lang::get('lingos::sentry.not_suspended') }}</h4>
                        <p>
                            <a href="{{ route('admin.users.throttling.update',array($user->id,'suspend')) }}"
                               class="btn btn-danger" title="{{ Lang::get('lingos::sentry.ban_user') }}"
                               data-method="put" data-modal-text="{{ Lang::get('lingos::sentry.suspend_user_confirm') }}">
                                <i class="icon-ban-circle"></i>
                                {{ Lang::get('lingos::sentry.suspend_user') }}
                            </a>
                        </p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

@stop
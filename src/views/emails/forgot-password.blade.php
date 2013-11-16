@extends(Config::get('vedette::vedette_views.email_layout'))

@section('content')
<p>{{ trans('lingos::email.hello') }} {{ $user->first_name }},</p>

<p>{{ trans('lingos::email.click_update_password') }}</p>

<p><a href="{{ $forgotPasswordUrl }}">{{ $forgotPasswordUrl }}</a></p>

<p>{{ trans('lingos::email.regards') }},</p>

<p>{{ Config::get('vedette::vedette_config.site_team') }}</p>
@stop

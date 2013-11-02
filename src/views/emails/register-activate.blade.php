@extends(Config::get('vedette::views.email_layout'))

@section('content')
<p>{{ Lang::get('lingos::email.hello') }} {{ $user->first_name }},</p>

<p>{{ Lang::get('lingos::email.welcome_to') }} {{ Config::get('vedette::site_config.site_team') }}!
{{ Lang::get('lingos::email.click_to_confirm') }}:</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>{{ Lang::get('lingos::email.regards') }},</p>

<p>{{ Config::get('vedette::site_config.site_team') }}</p>
@stop

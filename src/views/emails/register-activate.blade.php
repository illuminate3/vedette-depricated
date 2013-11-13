@extends(Config::get('vedette::views.email_layout'))

@section('content')
<p>{{ trans('lingos::email.hello') }} {{ $user->first_name }},</p>

<p>{{ trans('lingos::email.welcome_to') }} {{ Config::get('vedette::site_config.site_team') }}!
{{ trans('lingos::email.click_to_confirm') }}:</p>

<p><a href="{{ $activationUrl }}">{{ $activationUrl }}</a></p>

<p>{{ trans('lingos::email.regards') }},</p>

<p>{{ Config::get('vedette::site_config.site_team') }}</p>
@stop

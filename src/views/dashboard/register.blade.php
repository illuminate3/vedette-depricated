@extends(Config::get('vedette::views.layout'))

@section('header')
    <h3>
        <i class="icon-edit"></i>
        {{ Lang::get('lingos::auth.register') }}
    </h3>
@stop

@section('content')
    <div class="row">
        <div class="span12">

            <div class="block">
                <p class="block-heading">{{ Lang::get('vedette::vedette.registration') }}</p>
                <div class="block-body">
                    {{ Former::horizontal_open(route('admin.register')) }}
                        <fieldset>
                            <legend>{{ Lang::get('vedette::vedette.personal_information') }}</legend>
                            {{ Former::xlarge_text('first_name', Lang::get('lingos::general.first_name') ) }}
                            {{ Former::xlarge_text('last_name', Lang::get('lingos::general.last_name') ) }}
                        </fieldset>
                        <fieldset>
                            <legend>{{ Lang::get('lingos::general.email') }}</legend>
                            {{ Former::xlarge_text('email', Lang::get('lingos::general.email') ) }}
                        </fieldset>
                        <fieldset>
                            <legend>{{ Lang::get('lingos::auth.password') }}</legend>
                            {{ Former::xlarge_password('password', Lang::get('lingos::auth.password') ) }}
                            {{ Former::xlarge_password('password_confirmation', Lang::get('lingos::auth.confirm_password') ) }}
                        </fieldset>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">{{ Lang::get('lingos::auth.register') }}</button>
                        </div>
                    {{ Former::close() }}
                </div>
            </div>

        </div>
    </div>
@stop

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
        {{ Lang::get('vedette::vedette.help_user_create') }}
    </p>
@stop
@section('content')
    <div class="row">
        <div class="span12">
            {{Former::horizontal_open( route('admin.users.store') )}}

            <div class="block">
                <p class="block-heading">{{ Lang::get('lingos::auth.add_user') }}</p>
                <div class="block-body">

                    <legend><small>items mark with * are required.</small></legend>
                    {{ Former::xlarge_text('first_name', Lang::get('lingos::general.first_name') )->requireds() }}
                    {{ Former::xlarge_text('last_name', Lang::get('lingos::general.last_name') )->requireds() }}
                    {{ Former::xlarge_text('email',Lang::get('lingos::general.email') )->requireds() }}

                    <legend>Password</legend>
                    {{ Former::xlarge_password('password', Lang::get('lingos::auth.password') )->requireds() }}
                    {{ Former::xlarge_password('password_confirmation', Lang::get('lingos::auth.confirm_password') )->requireds() }}

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">{{ Lang::get('lingos::button.save_changes') }}</button>
                        <a href="{{route('admin.users.index')}}" class="btn">{{ Lang::get('lingos::button.cancel') }}</a>
                    </div>

                </div>
            </div>

            {{Former::close()}}
        </div>
    </div>
@stop

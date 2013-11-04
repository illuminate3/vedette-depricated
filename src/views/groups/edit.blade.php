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
        {{ Lang::get('vedette::vedette.help_user_groups_edit') }}
    </p>
    <br>
     <p class="text-info">
        {{ Lang::get('vedette::vedette.visit_sentry_site') }}
    </p>
@stop
@section('content')
    <div class="row">
        <div class="span12">
            {{ Former::horizontal_open(route('auth.groups.update', array($group->id)))->method('PUT') }}
            <div class="block">
                <p class="block-heading">{{ Lang::get('lingos::general.edit') }} "{{ $group->name }}" {{ Lang::get('lingos::sentry.group') }}</p>
                <div class="block-body">
                    {{ Former::xlarge_text('name','Name')->value($group->name)->required() }}
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

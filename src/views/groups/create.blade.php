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
        Users can be placed into groups to manage permissions.
    </p>
    <br>
     <p class="text-info">
        {{ Lang::get('vedette::vedette.visit_sentry_site') }}
    </p>
@stop
@section('content')
    <div class="row">
        <div class="span12">
            {{ Former::horizontal_open(route('admin.groups.store')) }}
            <div class="block">
                <p class="block-heading">Add New Group</p>
                <div class="block-body">

                    {{ Former::xlarge_text('name','Name')->required() }}

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">{{ Lang::get('lingos::button.save_changes') }}</button>
                        <a href="{{route('admin.groups.index')}}" class="btn">{{ Lang::get('lingos::button.cancel') }}</a>
                    </div>
                </div>
            </div>

            {{ Former::close() }}
        </div>
    </div>
@stop

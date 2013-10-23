@extends(Config::get('vedette::views.layout'))

@section('header')
    <h3>
        <i class="icon-user"></i>
        Users
    </h3>
@stop
@section('help')
    <p class="lead">{{ Lang::get('lingos::general.users') }}</p>
    <p>
        {{ Lang::get('vedette::vedette.help_user_edit') }}
    </p>
@stop
@section('content')
    <div class="row">
        <div class="span12">

            {{Former::horizontal_open( route('admin.users.update', array($user->id)), 'PUT' )}}

            <div class="block">
                <p class="block-heading">{{ Lang::get('lingos::general.edit_user') }} &quot;{{ $user->first_name }} {{ $user->last_name }}&quot;</p>
                <div class="block-body">
                    <div class="btn-toolbar">
                        <a href="{{ route('admin.users.destroy', array($user->id)) }}"
                            class="btn btn-danger" rel="tooltip" title="{{ Lang::get('lingos::general.delete_user') }}"
                            data-modal-text="{{ Lang::get('vedette::vedette.delete_user') }}" data-method="delete">
                            <i class="icon-trash"></i>
                            {{ Lang::get('lingos::general.delete') }}
                        </a>
                    </div>

                    <legend><small>{{ Lang::get('vedette::vedette.items_with_required') }}</small></legend>
                    {{ Former::xlarge_text('first_name', Lang::get('lingos::general.first_name'), $user->first_name)->required() }}
                    {{ Former::xlarge_text('last_name', Lang::get('lingos::general.last_name'), $user->last_name)->required() }}
                    {{ Former::xlarge_text('email',Lang::get('lingos::general.email'), $user->email)->required() }}

                    <legend>{{ Lang::get('lingos::sentry.groups') }}</legend>
                    <div class="control-group">
                        <label for="groups[]" class="control-label">{{ Lang::get('lingos::sentry.groups') }}</label>
                        <div class="controls">
                            <select id="groups" name="groups[]" class="select2" multiple="true">
                            @foreach($groups as $group)
                                @if( in_array( $group->id, Input::old('groups', array())) or in_array($group->id, $userGroupsId) )
                                    <option selected="selected" value="{{ $group->id }}">{{ $group->name }}</option>
                                @else
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <legend>{{ Lang::get('lingos::auth.password') }} <small>{{ Lang::get('vedette::vedette.leave_blank_keep_same') }}</small></legend>
                    {{ Former::xlarge_password('password', Lang::get('lingos::auth.password') ) }}
                    {{ Former::xlarge_password('password_confirmation', Lang::get('lingos::auth.confirm_password') ) }}

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

@extends(Config::get('vedette::views.layout'))

@section('css')
@stop

@section('page_title')
	- {{ Lang::get('lingos::auth.register') }}
@stop

@section('title')
	<h1>
		<i class="fa fa-pencil-square-o fa-lg"></i>
		{{ Lang::get('lingos::auth.register') }}
	</h1>
@stop

@section('content')
<div class="row">

<div class="block">
<div class="block-body">
{{ Former::horizontal_open(route('admin.register')) }}
<fieldset>
	<legend><i class="fa fa-user"></i>{{ Lang::get('vedette::vedette.personal_information') }}</legend>
	{{ Former::text('first_name', '')
		->prepend('<i class="fa fa-check-circle"></i>')
		->class('form-control')
		->id('first_name')
		->placeholder(Lang::get('lingos::general.first_name'))
		->autofocus()
	}}
	{{ Former::text('last_name', '')
		->prepend('<i class="fa fa-check-circle-o"></i>')
		->class('form-control')
		->id('last_name')
		->placeholder(Lang::get('lingos::general.last_name'))
	}}
</fieldset>

<br>

<fieldset>
	<legend><i class="fa fa-envelope-o"></i>{{ Lang::get('lingos::general.email') }}</legend>
	{{ Former::text('email', '')
		->prepend('<i class="fa fa-envelope-o"></i>')
		->class('form-control')
		->id('email')
		->placeholder(Lang::get('lingos::general.email'))
	}}
</fieldset>

<br>

<fieldset>
	<legend><i class="fa fa-key"></i>{{ Lang::get('lingos::auth.password') }}</legend>
	{{ Former::password('password', '')
		->prepend('<i class="fa fa-unlock-o"></i>')
		->class('form-control')
		->id('password')
		->placeholder(Lang::get('lingos::auth.password'))
	}}
	{{ Former::password('password_confirmation', '')
		->prepend('<i class="fa fa-unlock"></i>')
		->class('form-control')
		->id('password_confirmation')
		->placeholder(Lang::get('lingos::auth.confirm_password'))
	}}
</fieldset>


<hr>

<div class="margin-top">
	{{ Former::actions()
		->success_submit(Lang::get('lingos::button.register'))
		->inverse_reset(Lang::get('lingos::button.reset'))
	}}
</div>

{{ Former::close() }}
</div>
</div>



        <div class="span12">

            <div class="block">
                <p class="block-heading">{{ Lang::get('lingos::auth.registration') }}</p>
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

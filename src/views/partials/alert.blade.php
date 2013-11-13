@if ( Session::has('errors') )
    <div class="row">
        <div class="span12 margin-10-top">
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
11111                {{ trans('vedette::vedette.alert_validation_failed') }}
            </div>
        </div>
    </div>
@endif

@if ( Session::has('success') )
    <div class="row">
        <div class="span12">
            <div class="alert alert-success margin-10-top">
                <button type="button" class="close" data-dismiss="alert">×</button>
22222                {{ Session::get('success') }}
            </div>
        </div>
    </div>
@endif

@if ( Session::has('warning') )
    <div class="row">
        <div class="span12">
            <div class="alert alert-warning margin-10-top">
                <button type="button" class="close" data-dismiss="alert">×</button>
33333                {{ Session::get('warning') }}
            </div>
        </div>
    </div>
@endif

@if ( Session::has('error') )
    <div class="row">
        <div class="span12">
            <div class="alert alert-danger margin-10-top">
                <button type="button" class="close" data-dismiss="alert">×</button>
44444                {{ Session::get('error') }}
            </div>
        </div>
    </div>
@endif

@if ( Session::has('info') )
    <div class="row">
        <div class="span12">
            <div class="alert alert-info margin-10-top">
                <button type="button" class="close" data-dismiss="alert">×</button>
55555                {{ Session::get('info') }}
            </div>
        </div>
    </div>
@endif

<?php namespace Illuminate3\Vedette\Controllers;

//
// @author Steve Montambeault
// @link   http://stevemo.ca
//

use Controller;
use View;
use Config;

class BaseController extends Controller {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
        //share the config option to all the views
        View::share('vedette', Config::get('vedette::site_config'));
/*
        View::share('vedette_package', Config::get('package.vedette_config'));
        View::share('vedette_validators', Config::get('validators.validation'));
        View::share('vedette_views', Config::get('views.views'));
*/
    }

    /**
     * get the validation service
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  string $service
     * @param  array $inputs
     * @return Object
     */
    protected function getValidationService($service, array $inputs = array())
    {
        $class = '\\'.ltrim(Config::get("vedette::validation.{$service}"), '\\');
        return new $class($inputs);
    }

}

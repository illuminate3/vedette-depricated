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
        View::share('vedette', Config::get('vedette::vedette_config'));
/*
        View::share('vedette_package', Config::get('vedette::package'));
        View::share('vedette_validators', Config::get('vedette::validators'));
        View::share('vedette_views', Config::get('vedette::views'));
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

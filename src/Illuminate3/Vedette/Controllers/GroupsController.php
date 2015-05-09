<?php namespace Illuminate3\Vedette\Controllers;

//
// @author Steve Montambeault
// @link   http://stevemo.ca
//

use View;
use Redirect;
use Input;
use Lang;
use Sentry;
use Event;
use Config;
use Cartalyst\Sentry\Groups\NameRequiredException;
use Cartalyst\Sentry\Groups\GroupExistsException;
use Cartalyst\Sentry\Groups\GroupNotFoundException;

class GroupsController extends BaseController {


    /**
     * Display all the groups
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function index()
    {
        $groups = Sentry::getGroupProvider()->findAll();
        return View::make(Config::get('vedette::vedette_views.groups_index'), compact('groups'));
    }

    /**
     * Display create a new group form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function create()
    {
        return View::make(Config::get('vedette::vedette_views.groups_create'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function edit($id)
    {
        try
        {
            $group = Sentry::getGroupProvider()->findById($id);
            return View::make(Config::get('vedette::vedette_views.groups_edit'),compact('group'));
        }
        catch ( GroupNotFoundException $e)
        {
            return Redirect::route('auth.groups.index')->with('error', $e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function store()
    {
        try
        {
            $group = Sentry::getGroupProvider()->create(Input::only('name'));
            Event::fire('groups.create', array($group));
            return Redirect::route('auth.groups.index')->with('success', trans('lingos::sentry.group_success.create'));
        }
        catch (NameRequiredException $e)
        {
            return Redirect::back()->withInput()->with('error', $e->getMessage());
        }
        catch (GroupExistsException $e)
        {
            return Redirect::back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function update($id)
    {
        try
        {
            $group = Sentry::getGroupProvider()->findById($id);
            $group->name = Input::get('name');
            $group->save();
            Event::fire('groups.update', array($group));
            return Redirect::route('auth.groups.index')->with('success', trans('lingos::sentry.group_success.update') );
        }
        catch (GroupNotFoundException $e)
        {
            return Redirect::back()->withInput()->with('error', $e->getMessage());
        }
        catch (GroupExistsException $e)
        {
            return Redirect::back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function destroy($id)
    {
        try
        {
            $group = Sentry::getGroupProvider()->findById($id);
            $eventData = $group;
            $group->delete();
            Event::fire('groups.delete', array($eventData));
            return Redirect::route('auth.groups.index')->with('success', trans('lingos::sentry.group_success.delete'));
        }
        catch (GroupNotFoundException $e)
        {
            return Redirect::route('auth.groups.index')->with('error',$e->getMessage());
        }
    }

}

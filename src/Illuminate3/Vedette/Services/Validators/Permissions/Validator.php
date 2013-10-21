<?php namespace Illuminate3\Vedette\Services\Validators\Permissions;

use Illuminate3\Vedette\Services\Validators\ValidatorService;

class Validator extends ValidatorService {

   /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = array(
        'name'        => 'required|unique:permissions',
        'permissions' => 'required'
    );


    public function passes()
    {
        if (isset($this->data['id']))
        {
            static::$rules['name'] = "required|unique:permissions,name,{$this->data['id']}";
        }

        return parent::passes();
    }

}
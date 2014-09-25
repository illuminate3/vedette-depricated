<?php

return [

'identified_by'		=> ['username', 'email'],

// The Super Admin role
// (returns true for all permissions)
'super_admin'		=> 'Super Admin',

// DB prefix for tables
'prefix'			=> '',

// Define Models if you extend them.
'models' => [
	'user'			=> 'Illuminate3\Vedette\models\User',
	'role'			=> 'Illuminate3\Vedette\models\Role',
	'permission'	=> 'Illuminate3\Vedette\models\Permission',
]

];

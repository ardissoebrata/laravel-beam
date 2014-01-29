<?php

use Zizaco\Confide\ConfideUser;

class User extends ConfideUser {

	public function role()
	{
		return $this->belongsTo('Role', 'role_id', 'id');
	}
}
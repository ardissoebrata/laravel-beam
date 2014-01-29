<?php

class Rule extends \LaravelBook\Ardent\Ardent {
	
	protected $table = 'acl_rules';
	
	protected $guarded = array();

	public function children()
	{
		return $this->belongsToMany('Role', 'acl_role_parents', 'parent_id', 'role_id')->withPivot('order_num');
	}

	public function parents()
	{
		return $this->belongsToMany('Role', 'acl_role_parents', 'role_id', 'parent_id')->withPivot('order_num');
	}
}

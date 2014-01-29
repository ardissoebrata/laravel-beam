<?php

class Role extends \LaravelBook\Ardent\Ardent {
	
	protected $table = 'acl_roles';
	
	protected $guarded = array();

	public static $rules = array(
		'name'		=> 'required|unique',
	);
	
	public function children()
	{
		return $this->belongsToMany('Role', 'acl_role_parents', 'parent_id', 'role_id')->withPivot('order_num');
	}

	public function parents()
	{
		return $this->belongsToMany('Role', 'acl_role_parents', 'role_id', 'parent_id')->withPivot('order_num');
	}
	
	public function resources()
	{
		return $this->belongsToMany('Resource', 'acl_rules', 'role_id', 'resource_id')->withPivot(array('access', 'privilege'));
	}
	
	public function scopeOrderByName($query)
	{
		return $query->orderBy('name');
	}
	
	public function scopeRoots($query)
	{
		return $query->orderByName()
				->where('parent_id', null);
	}
	
	public function users()
	{
		return $this->hasMany('User');
	}
}

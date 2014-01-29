<?php

class Resource extends \LaravelBook\Ardent\Ardent {
	
	protected $table = 'acl_resources';
	
	protected $guarded = array();

	public static $rules = array(
		'name'		=> 'required|unique',
		'type'		=> 'required|in:action,closure,other',
		'parent_id'	=> 'exists:acl_resources,id'
	);
	
	public function children()
	{
		return $this->hasMany('Resource', 'parent_id');
	}

	public function parent()
	{
		return $this->belongsTo('Resource', 'parent_id');
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
	
	public function scopeOtherTypes($query)
	{
		return $query->orderByName()
				->where('type', '!=', 'closure')
				->where('type', '!=', 'action');
	}
	
	public function scopeExcept($query, $id)
	{
		return $query->otherTypes()
				->where('id', '!=', $id);
	}
}

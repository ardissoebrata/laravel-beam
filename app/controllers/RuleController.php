<?php

class RuleController extends \BaseController {
	
	/**
	 * Display a list of Rules
	 * 
	 * @return Response
	 */
	public function getIndex()
	{
		$roles = Role::orderByName()->get();
		$resources = NULL;
		$curr_role = NULL;
		if (Input::get('role_id', false))
		{
			$curr_role = Role::with(array('resources',
					'parents' => function($query) {
						$query->orderBy('order_num');
					}))
					->where('id', Input::get('role_id'))
					->first();
			if (!is_null($curr_role))
			{
				Acl::updateResources();
				$resources = Resource::roots()
						->get();
				Acl::build();
			}
		}
		return View::make('rule/index', compact('roles', 'curr_role', 'resources'));
	}

	/**
	 * Save Rule data
	 * 
	 * @return Response
	 */
	public function postEdit()
	{
		$role = Role::findOrFail(Input::get('role_id'));
		$resource_rules = Input::get('resource_rule');
		
		$rules = array();
		foreach($resource_rules as $resource_id => $access)
		{
			if ($access != 'inherit')
			{
				$rules[$resource_id] = array('access' => $access);
			}
		}
		
		$role->resources()->sync($rules);
		
		return Redirect::action('RuleController@getIndex', array('role_id' => $role->id))
				->with('success', Lang::get('acl.alerts.rule_updated', array('name' => $role->name)));
	}
}

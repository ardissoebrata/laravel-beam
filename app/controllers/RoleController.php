<?php

class RoleController extends \BaseController {

	/**
	 * Display a list of Roles
	 * 
	 * @return Response
	 */
	public function getIndex()
	{
		$roles = Role::with(array('parents' => function($query) {
			$query->orderBy('order_num');
		}))->get();
		return View::make('role/index', compact('roles')); 
	}
	
	/**
	 * Display Role create form
	 * 
	 * @return Response
	 */
	public function getCreate()
	{
		$this->saveReferer();
		return View::make('role/edit');
	}
	
	/**
	 * Save a new Role data
	 * 
	 * @return Response
	 */
	public function postCreate()
	{
		$role = new Role;
		$role->name = Input::get('name');

		if ($role->updateUniques())
		{
			$input_parents = Input::get('parents', false);
			if ($input_parents)
			{
				$parents = array();
				foreach($input_parents as $index => $parent)
				{
					$parents[$parent] = array('order_num' => $index);
				}
				$role->parents()->sync($parents);
			}
			
			return $this->redirectReferer(Redirect::action('RoleController@getIndex'))
					->with('success', Lang::get('acl.alerts.role_created'));
		}
		else
		{
			return Redirect::action('RoleController@getCreate')
							->withInput(Input::all())
							->withErrors($role->errors());
		}
	}
	
	/**
	 * Display Role edit form
	 * 
	 * @return Response
	 */
	public function getEdit($id)
	{
		$this->saveReferer();
		$role = Role::with(array('parents' => function($query) {
			$query->orderBy('order_num');
		}))->where('id', $id)->first();
		return View::make('role/edit', compact('role'));
	}

	/**
	 * Save Role data
	 * 
	 * @return Response
	 */
	public function postEdit()
	{
		$role = Role::with(array('parents' => function($query) {
			$query->orderBy('order_num');
		}))->where('id', Input::get('id'))->first();
		$role->name = Input::get('name');

		if ($role->updateUniques())
		{
			$input_parents = Input::get('parents', false);
			$parents = array();
			if ($input_parents)
			{
				foreach($input_parents as $index => $parent)
				{
					$parents[$parent] = array('order_num' => $index);
				}
			}
			$role->parents()->sync($parents);
			
			return $this->redirectReferer(Redirect::action('RoleController@getIndex'))
							->with('success', Lang::get('acl.alerts.role_updated'));
		}
		else
		{
			return Redirect::action('RoleController@getCreate')
							->withInput(Input::all())
							->withErrors($role->errors());
		}
	}
	
	/**
	 * Delete a Role
	 * 
	 * @param integer $id
	 * @return Response
	 */
	public function postDelete($id)
	{
		$role = Role::findOrFail($id);
		$deleted_role = $role->name;
		$role->delete();
		return $this->redirectReferer(Redirect::action('RoleController@getIndex'))
				->with('success', Lang::get('acl.alerts.role_deleted', array('name' => $deleted_role)));
	}
}
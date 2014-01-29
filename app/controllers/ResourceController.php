<?php

class ResourceController extends \BaseController {

	/**
	 * Display a list of Resources
	 * 
	 * @return Response
	 */
	public function getIndex()
	{
		Acl::updateResources();
		$resources = Resource::where('parent_id', null)
				->orderBy('name')
				->get();
		return View::make('resource/index', compact('resources')); 
	}
	
	/**
	 * Display Resource create form
	 * 
	 * @return Response
	 */
	public function getCreate()
	{
		$this->saveReferer();
		return View::make('resource/create');
	}
	
	/**
	 * Save a new Resource data
	 * 
	 * @return Response
	 */
	public function postCreate()
	{
		$resource = new Resource;
		$resource->name = Input::get('name');
		$resource->type = 'other';
		if (Input::get('parent_id', false))
			$resource->parent_id = Input::get('parent_id');

		if ($resource->updateUniques())
		{
			return $this->redirectReferer(Redirect::action('ResourceController@getIndex'))
							->with('success', Lang::get('acl.alerts.resource_created'));
		}
		else
		{
			return Redirect::action('ResourceController@getCreate')
							->withInput(Input::all())
							->withErrors($resource->errors());
		}
	}
	
	/**
	 * Display Resource edit form
	 * 
	 * @return Response
	 */
	public function getEdit($id)
	{
		$this->saveReferer();
		$resource = Resource::findOrFail($id);
		return View::make('resource/edit', compact('resource'));
	}

	/**
	 * Save Resource data
	 * 
	 * @return Response
	 */
	public function postEdit()
	{
		$resource = Resource::findOrFail(Input::get('id'));
		
		if ($resource->type != 'closure' && $resource->type != 'action')
			$resource->name = Input::get('name');
		
		if (!Input::get('parent_id', false))
			$resource->parent_id = null;
		else
			$resource->parent_id = Input::get('parent_id');

		if ($resource->updateUniques())
		{
			return $this->redirectReferer(Redirect::action('ResourceController@getIndex'))
							->with('success', Lang::get('acl.alerts.resource_updated'));
		}
		else
		{
			return Redirect::action('ResourceController@getEdit')
							->withInput(Input::all())
							->withErrors($resource->errors());
		}
	}
	
	/**
	 * Delete Resource data
	 * 
	 * @param integer $id
	 * @return Response
	 */
	public function postDelete($id)
	{
		$resource = Resource::findOrFail($id);
		$deleted_resource = $resource->name;
		$resource->delete();
		return $this->redirectReferer(Redirect::action('ResourceController@getIndex'))
				->with('success', Lang::get('acl.alerts.resource_deleted', array('name' => $deleted_resource)));
	}
}
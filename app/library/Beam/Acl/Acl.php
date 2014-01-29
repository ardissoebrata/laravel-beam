<?php namespace Beam\Acl;

use Zend\Permissions\Acl\Acl as Zend_Acl;
use Zend\Permissions\Acl\Resource\GenericResource as Zend_Resource;
use Zend\Permissions\Acl\Role\GenericRole as Zend_Role;
use Illuminate\Support\Facades\Route;

class Acl {
	
	/**
	 *
	 * @var Zend\Permissions\Acl\Acl
	 */
	private static $acl;
	
	public static function getAcl()
	{
		if (!isset(self::$acl) || empty(self::$acl))
			self::build();
		
		return self::$acl;
	}
	
	public static function build()
	{
		self::$acl = new Zend_Acl();
		self::buildResources(\Resource::roots()->get());
		self::buildRoles();
		self::buildRules();
	}
	
	public static function buildResources($resources, $parent_name = '')
	{
		foreach($resources as $resource)
		{
			if (empty($parent_name))
				self::$acl->addResource(new Zend_Resource($resource->name));
			else
				self::$acl->addResource(new Zend_Resource($resource->name), $parent_name);
			
			$children = $resource->children;
			if (!$children->isEmpty())
				self::buildResources ($children, $resource->name);
		}
	}
	
	public static function buildRoles()
	{
		$roles = \Role::with('parents')->get();
		
		// Create role and parents array.
		$role_tree = array();
		foreach($roles as $role)
		{
			$parents = array();
			foreach($role->parents as $parent)
			{
				$parents[$parent->pivot->order_num] = $parent->name;
			}
			$role_tree[] = array(
				'name'		=> $role->name,
				'parents'	=> $parents
			);
		}
		
		// Add Administrator role
		self::$acl->addRole(new Zend_Role('Administrator'));
		while(!empty($role_tree))
		{
			// Remove first role from array.
			$role = array_shift($role_tree);
			
			// If role exists, continue;
			if (self::$acl->hasRole($role['name']))	continue;
			
			// Check if every role parents exists.
			$is_parent_ok = TRUE;
			foreach($role['parents'] as $parent_name)
			{
				if (!self::$acl->hasRole($parent_name))
				{
					$is_parent_ok = FALSE;
					break;
				}
			}
			
			// Create role or push role for next iteration.
			if (empty($role['parents']))
				self::$acl->addRole(new Zend_Role($role['name']));
			elseif ($is_parent_ok)
				self::$acl->addRole(new Zend_Role($role['name']), $role['parents']);
			else
				array_push($role_tree, $role);
		}
	}
	
	public static function buildRules()
	{
		// Gives Administrator all privileges.
		self::$acl->allow('Administrator');
		
		$roles = \Role::with('resources')->get();
		foreach($roles as $role)
		{
			if ($role->name != 'Administrator')
			{
				$resources = $role->resources;
				foreach($resources as $resource)
				{
					if ($resource->pivot->access == 'allow')
						self::$acl->allow($role->name, $resource->name);
					else
						self::$acl->deny($role->name, $resource->name);
				}
			}
		}
	}
	
	public static function updateResources()
	{
		// Create list of routes.
		$routes = Route::getRoutes();
		$resource_routes = array();
		foreach($routes as $route) 
		{
			if (isset($route->beforeFilters()['auth'])) 
			{
				$action_name = $route->getActionName();
				$type = 'action';
				if ($action_name == 'Closure')
				{
					$action_name = $route->getPath();
					$type = 'closure';
				}
				$resource_routes[$action_name] = $type;
			}
		}
		
		// Delete non-exist routes.
		$resources = \Resource::where('type', 'closure')
				->orWhere('type', 'action')
				->get();
		foreach($resources as $resource)
		{
			if (!isset($resource_routes[$resource->name]))
				$resource->delete();
		}
		
		// Add new routes.
		foreach($resource_routes as $route_name => $type)
		{
			$resource = \Resource::where('name', $route_name)->first();
			if (!$resource)
			{
				$resource = new \Resource();
				$resource->name = $route_name;
				$resource->type = $type;
				$resource->updateUniques();
			}
		}
	}
	
	public static function isAllowed($role_name, $resource_name, $privilege = NULL)
	{
		if (!self::$acl->hasRole($role_name) || !self::$acl->hasResource($resource_name)) return FALSE;
		
		return self::$acl->isAllowed($role_name, $resource_name, $privilege);
	}
}

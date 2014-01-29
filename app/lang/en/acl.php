<?php

return array(
	
	// Fields
	'name'		=> 'Name',
	'type'		=> 'Type',
	'parent'	=> 'Parent',
	'updated'	=> 'Updated',
	'created'	=> 'Created',
	
	// Buttons
	'new'		=> 'New',
	'save'		=> 'Save',
	'delete'	=> 'Delete',
	'cancel'	=> 'Cancel',
	
	// Views
	'resource'	=> array(
		'title'		=> 'Resource',
		'emptylist'	=> 'No resources found!!',
		'noparent'	=> '(No Parent)',
		'create'	=> 'Create Resource',
		'delete_confirmation'	=> array(
			'title'		=> 'Delete Confirmation',
			'content'	=> 'Are you sure you want to delete this Resource?'
		),
	),
	'role'		=> array(
		'title'					=> 'Role',
		'empty_list'			=> 'No roles found!!',
		'parents'				=> 'Parents',
		'no_parent'				=> 'No Parent',
		'no_parent_selected'	=> 'No Parent Selected',
		'create'				=> 'Create Role',
		'edit'					=> 'Edit Role',
		'delete'				=> 'Delete Role',
		'drag_to_reorder'		=> 'Drag Parents to reorder',
		'select_to_add'			=> '(Select to add as Parent)',
		'delete_confirmation'	=> array(
			'title'		=> 'Delete Confirmation',
			'content'	=> 'Are you sure you want to delete this Role?'
		),
	),
	'rule'		=> array(
		'title'					=> 'Rule',
		'please_select'			=> 'Please select role on the left to assign rules.',
		'resource'				=> 'Resource',
		'allow'					=> 'Allow',
		'deny'					=> 'Deny',
		'inherit'				=> 'Inherit',
	),
	
	// Alerts
	'alerts'	=> array(
		'resource_created'	=> 'A new Resource has been created successfully.',
		'resource_updated'	=> 'A Resource has been updated successfully.',
		'resource_deleted'	=> 'Resource ":name" has been deleted.',
		'role_created'		=> 'A new Role has been created successfully.',
		'role_updated'		=> 'A Role has been updated successfully.',
		'role_deleted'		=> 'Role ":name" has been deleted.',
		'rule_updated'		=> 'Role ":name" permissions has been updated successfully.',
	),
	
);

{{ Former::hidden('id') }}
@if ($resource->type == 'closure' || $resource->type == 'action')
{{ Former::staticControl('name', 'acl.name')->forceValue($resource->name) }}
@else
{{ Former::text('name', 'acl.name')
			->placeholder('acl.name') }}
@endif
{{ Former::staticControl('type')->forceValue(ucwords($resource->type)) }}
{{ Former::select('parent_id', 'acl.parent')->options(array('' => Lang::get('acl.resource.noparent')))
			->fromQuery(Resource::except($resource->id)->get(), 'name')
			->addClass('selectpicker') }}

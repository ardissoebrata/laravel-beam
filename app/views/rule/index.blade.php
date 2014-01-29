@extends('layouts/default')

@section('styles')
<style>
	#rules td label {
		font-weight: normal;
	}
	.form-horizontal td .form-control-static,
	.form-horizontal td .radio {
		padding-top: 0;
	}
</style>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="page-header">
			<h1>{{ Lang::get('acl.rule.title') }}</h1>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-3">
		<div class="list-group">
			@foreach($roles as $role)
			<a href="{{ URL::action('RuleController@getIndex', array('role_id' => $role->id)) }}" class="list-group-item{{ (!empty($curr_role) && ($curr_role->id == $role->id)) ? ' active' : '' }}">
				{{ $role->name }}
			</a>
			@endforeach
		</div>
		<div class="list-group">
			<a href="{{ URL::action('RoleController@getCreate') }}" class="list-group-item">
				<span class="fa fa-plus"></span> {{ Lang::get('acl.role.create') }}
			</a>
			<a href="{{ URL::action('ResourceController@getCreate') }}" class="list-group-item">
				<span class="fa fa-plus"></span> {{ Lang::get('acl.resource.create') }}
			</a>
		</div>
	</div>
	<div class="col-md-9">
		@if (empty($resources))
		<div class="well well-large">
			{{ Lang::get('acl.rule.please_select') }}
		</div>
		@else
		<h2>
			<a href="{{ URL::action('RoleController@getEdit', array($curr_role->id)) }}" class="btn btn-default btn-sm pull-right">
				<span class="fa fa-pencil"></span>
				{{ Lang::get('acl.role.edit') }}
			</a>
			{{ $curr_role->name }}
			<small>
				@if ($curr_role->parents->isEmpty())
				{{ Lang::get('acl.role.no_parent') }}
				@else
				Parents: 
				<?php
				foreach($curr_role->parents as $index => $parent)
				{
					if ($index > 0) echo ', ';
					echo link_to_action('RuleController@getIndex', $parent->name, array('role_id' => $parent->id));
				}
				?>
				@endif
			</small>
		</h2>
		{{ Former::open()
					->method('POST')
					->action(URL::action('RuleController@postEdit'))
					->accept_charset('UTF-8')
					->role('form') }}
		{{ Former::hidden('role_id', $curr_role->id) }}
		<p>
			<button class="btn btn-block btn-primary" type="submit">
				<span class="fa fa-save"></span> {{ Lang::get('acl.save') }}
			</button>
		</p>
		<table id="rules" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>{{ Lang::get('acl.rule.resource') }}</th>
					<th>{{ Lang::get('acl.rule.allow') }}</th>
					<th>{{ Lang::get('acl.rule.deny') }}</th>
					<th>{{ Lang::get('acl.rule.inherit') }}</th>
				</tr>
			</thead>
			<tbody>
			{{ displayResources($curr_role, $resources) }}
			</tbody>
		</table>
		<p>
			<button class="btn btn-block btn-primary" type="submit">
				<span class="fa fa-save"></span> {{ Lang::get('acl.save') }}
			</button>
		</p>
		{{ Former::close() }}
		@endif
	</div>
</div>

<?php
function displayResources($curr_role, $rows, $left = 0)
{
	foreach ($rows as $row)
	{
		$icon = 'fa-bookmark';
		switch($row->type)
		{
			case 'closure': 
				$icon = 'fa-bolt';
				break;
			case 'action':
				$icon = 'fa-gear';
				break;
		}

		$access = FALSE;
		if ($curr_role->resources->contains($row->id))
		{
			foreach($curr_role->resources as $resource)
			{
				if ($resource->id == $row->id)
				{
					$access = $resource->pivot->access;
					break;
				}
			}
		}
		
		if ($access == 'allow')
			Acl::getAcl()->removeAllow($curr_role->name, $row->name);
		elseif ($access == 'deny')
			Acl::getAcl()->removeDeny($curr_role->name, $row->name);
		?>
		<tr class="{{ ($access == 'allow' || Acl::isAllowed($curr_role->name, $row->name)) ? 'success' : '' }}">
			<td>
				<p class="form-control-static" style="padding-left: {{ $left }}em;">
					<span class="fa {{ $icon }}" title="{{ ucwords($row->type) }}"></span>
					<a href="{{ URL::action('ResourceController@getEdit', array($row->id)) }}">
						{{ $row->name }}
					</a>
				</p>
			</td>
			<td>
				<div class="radio">
					<label>
						{{ Form::radio('resource_rule[' . $row->id . ']', 'allow', $access == 'allow' ) }} {{ Lang::get('acl.rule.allow') }}
					</label>
				</div>
			</td>
			<td>
				<div class="radio">
					<label>
						{{ Form::radio('resource_rule[' . $row->id . ']', 'deny', $access == 'deny') }} {{ Lang::get('acl.rule.deny') }}
					</label>
				</div>
			</td>
			<td>
				<div class="radio">
					<label>
						{{ Form::radio('resource_rule[' . $row->id . ']', 'inherit', $access === FALSE) }} 
						@if (Acl::isAllowed($curr_role->name, $row->name))
						{{ Lang::get('acl.rule.allow') }}
						@else
						{{ Lang::get('acl.rule.deny') }}
						@endif
					</label>
				</div>
			</td>
		</tr>
		<?php
		if (!$row->children->isEmpty())
		{
			$children = $row->children->sortBy(function($row) 
				{
					return $row->name;
				});
			displayResources($curr_role, $children, $left + 1);
		}
	}
}
?>
@stop

@section('scripts')
<script>
(function($) {

	// The $ is now locally scoped 

	// Listen for the jQuery ready event on the document
	$(function() {

		// The DOM is ready!
		// Makes resource rows turns green when user select 'Allow'.
		$('#rules').on('click', ':radio', function() {
			var $this = $(this);
			if ($this.parent().text().trim() === "{{ Lang::get('acl.rule.allow') }}")
				$this.parents('tr').addClass('success');
			else
				$this.parents('tr').removeClass('success');
		});
		
		
	});

	// The rest of the code goes here!

}(window.jQuery));	
</script>
@stop
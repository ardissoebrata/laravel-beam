
{{ Former::hidden('id') }}
<div class="form-group">
	{{ Former::text('name', 'acl.name')
				->placeholder('acl.name') }}
</div>
<div class="form-group">
	<label for="parents" class="control-label col-lg-3 col-sm-5">Parents</label>
	<div class="col-lg-9 col-sm-7">
		<?php
		$parents = Form::getValueAttribute('parents');
		$parent_names = Form::getValueAttribute('parent_names');
		if (is_null($parents) && isset($role) && (count($role->parents) > 0))
		{
			$parents = array();
			$parent_names = array();
			foreach($role->parents as $parent)
			{
				$parents[] = $parent->id;
				$parent_names[] = $parent->name;
			}
		}
		?>
		<ul id="parents-list" class="list-group">
			@if (is_null($parents))
			<li class="list-group-item no-parents">
				{{ Lang::get('acl.role.no_parent_selected') }}
			</li>
			@else
			@foreach($parents as $index => $parent_id)
			<li class="list-group-item">
				<input type="hidden" name="parents[]" value="{{ $parent_id }}" />
				<input type="hidden" name="parent_names[]" value="{{ $parent_names[$index] }}" />
				{{ $parent_names[$index] }}
				<button type="button" class="close" aria-hidden="true">&times;</button>
			</li>
			@endforeach
			@endif
		</ul>
		<span class="help-block">Drag Parents to reorder</span>
		<?php
		$roles = Role::orderBy('name')->get();
		$parent_select = array();
		foreach($roles as $role_item)
		{
			$parent_select[$role_item->id] = $role_item->name;
		}
		?>
		<select id="parent-select" name="parent-select" class="form-control selectpicker">
			<option value="">(Select to add as Parent)</option>
			@foreach ($parent_select as $parent_id => $parent_name)
			@if ((!is_array($parents) || !in_array($parent_id, $parents)) && (!isset($role) || $parent_id != $role->id))
			<option value="{{ $parent_id }}">{{ $parent_name }}</option>
			@endif
			@endforeach
		</select>
	</div>
</div>

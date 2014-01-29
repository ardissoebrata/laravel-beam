@extends('layouts/default')

@section('styles')
<style>
	.table-hover td {
		cursor: pointer;
	}
</style>
@stop

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				{{ Button::link(URL::action('RoleController@getCreate'), Lang::get('acl.new'), array('class' => 'pull-right'))->with_icon('plus') }}
				<h1>{{ Lang::get('acl.role.title') }}</h1>
			</div>
			<table class="table table-bordered table-hover table-responsive table-striped">
				<thead>
					<tr>
						<th>{{ Lang::get('acl.name') }}</th>
						<th>{{ Lang::get('acl.parent') }}</th>
						<th>{{ Lang::get('acl.updated') }}</th>
						<th>{{ Lang::get('acl.created') }}</th>
					</tr>
				</thead>
				<tbody>
					@if (count($roles) > 0)
					@foreach($roles as $role)
					<tr data-target="{{ URL::action('RoleController@getEdit', $role->id) }}">
						<td>{{ $role->name }}</td>
						<td>
							<?php
							if (count($role->parents) == 0) echo '-';
							else 
							{
								foreach($role->parents as $index => $parent)
								{
									if ($index > 0) echo ', ';
									echo $parent->name;
								}
							}
							?>
						</td>
						<td>{{ $role->updated_at }}</td>
						<td>{{ $role->created_at }}</td>
					</tr>
					@endforeach
					@else
					<tr>
						<td colspan="5">
							{{ Lang::get('acl.role.empty_list') }}
						</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop

@section('scripts')
<script>
!function ($) {
	$(function(){
		$('.table-hover').on('click', 'tr[data-target]', function(e) {
			e.preventDefault();
			document.location.href = $(this).data('target');
		});
	});
}(jQuery);
</script>
@stop

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
				{{ Button::link(URL::action('ResourceController@getCreate'), Lang::get('acl.new'), array('class' => 'pull-right'))->with_icon('plus') }}
				<h1>{{ Lang::get('acl.resource.title') }}</h1>
			</div>
			<table class="table table-bordered table-hover table-responsive table-striped">
				<thead>
					<tr>
						<th>{{ Lang::get('acl.name') }}</th>
						<th>{{ Lang::get('acl.parent') }}</th>
					</tr>
				</thead>
				<tbody>
					@if (count($resources) > 0)
					{{ displayResources($resources) }}
					@else
					<tr>
						<td colspan="5">
							{{ Lang::get('acl.resource.emptylist') }}
						</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php
function displayResources($rows, $left = 0)
{
	foreach ($rows as $row)
	{
		?>
		<tr data-target="{{ URL::action('ResourceController@getEdit', $row->id) }}">
			<td>
				<?php
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
				?>
				<div style="padding-left: {{ $left }}em;">
					<span class="fa {{ $icon }}" title="{{ ucwords($row->type) }}"></span>
					{{ $row->name }}
				</div>
			</td>
			<td>{{ ($row->parent) ? $row->parent->name : '-' }}</td>
		</tr>
		<?php
		if (!$row->children->isEmpty())
		{
			$children = $row->children->sortBy(function($row) 
				{
					return $row->name;
				});
			displayResources($children, $left + 1);
		}
	}
}
?>
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

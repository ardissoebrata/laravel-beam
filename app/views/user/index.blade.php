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
				<h1>{{ Lang::get('confide.user') }}</h1>
			</div>
			<table class="table table-bordered table-hover table-responsive table-striped">
				<thead>
					<tr>
						<th>{{ Lang::get('confide.name') }}</th>
						<th>{{ Lang::get('confide.username') }}</th>
						<th>{{ Lang::get('confide.e_mail') }}</th>
						<th>{{ Lang::get('confide.confirmed') }}</th>
						<th>{{ Lang::get('confide.updated') }}</th>
						<th>{{ Lang::get('confide.registered') }}</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr data-target="{{ URL::action('UserController@getEdit', $user->id) }}">
						<td>{{ $user->name }}</td>
						<td>{{ $user->username }}</td>
						<td>{{ $user->email }}</td>
						<td>
							@if ($user->confirmed)
							<span class="fa fa-check-square-o"></span>
							@else
							<span class="fa fa-square-o"></span>
							@endif
						</td>
						<td>{{ $user->updated_at }}</td>
						<td>{{ $user->created_at }}</td>
					</tr>
					@endforeach
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

@extends('layouts/default')

@section('styles')
<link rel="stylesheet" href="/assets/bootstrap-select/bootstrap-select.css" media="screen">
@stop

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="page-header">
				<h1>{{ Lang::get('acl.role.title') }}</h1>
			</div>
			@if (isset($role))
			{{ Former::populate($role) }}
			{{ Former::horizontal_open()
						->method('POST')
						->action(URL::action('RoleController@postEdit'))
						->accept_charset('UTF-8')
						->role('form') }}
			@else
			{{ Former::horizontal_open()
						->method('POST')
						->action(URL::action('RoleController@postCreate'))
						->accept_charset('UTF-8')
						->role('form') }}
			@endif
						
			@include('role/form')
			@if (isset($role))
			{{ Former::actions( 
						Former::primary_submit('acl.save'),
						Former::link('acl.cancel', Session::get('url.referer', URL::action('RoleController@getIndex'))),
						Former::danger_button('acl.delete')->addClass('pull-right')->data_toggle('modal')->data_target('#delete-modal')) 
			}}
			@else
			{{ Former::actions( 
						Former::primary_submit('acl.save'),
						Former::link('acl.cancel', Session::get('url.referer', URL::action('RoleController@getIndex')))) 
			}}
			@endif
			
			{{ Former::close() }}
		</div>
	</div>
</div>

@if (isset($role))
{{ Form::open(array('action' => array('RoleController@postDelete', $role->id))) }}
{{ Modal::create('delete-modal')
			->header(Lang::get('acl.role.delete_confirmation.title'))
			->body(Lang::get('acl.role.delete_confirmation.content'))
			->footer( 
				Button::danger_submit(Lang::get('acl.delete')) .
				Button::normal(Lang::get('acl.cancel'), array('data-dismiss' => 'modal'))
			);
}}
{{ Form::close() }}
@endif

@stop

@section('scripts')
<script src="/assets/bootstrap-select/bootstrap-select.min.js"></script>
<script src="/assets/jquery-ui/ui/jquery.ui.core.js"></script>
<script src="/assets/jquery-ui/ui/jquery.ui.widget.js"></script>
<script src="/assets/jquery-ui/ui/jquery.ui.mouse.js"></script>
<script src="/assets/jquery-ui/ui/jquery.ui.sortable.js"></script>
<script>
	(function($) {
		$(function() {
			$('#parent-select').selectpicker()
				.on('change', function() {
					var $this = $(this);
					var $list = $('#parents-list');
					var parent_id = $this.val();
					var $parent_option = $this.find('[value="' + parent_id + '"]');
					var parent_name = $parent_option.text();
					
					$list.find('.no-parents').remove();
					$list.append('<li class="list-group-item"><input type="hidden" name="parents[]" value="' + parent_id + '" /><input type="hidden" name="parent_names[]" value="' + parent_name + '" />' + parent_name + '<button type="button" class="close" aria-hidden="true">&times;</button></li>');
					$parent_option.remove();
					$this.selectpicker('refresh');
				});
			$('#parents-list').sortable()
				.on('click', '.close', function() {
					var $this = $(this);
					var $li = $this.parent('li');
					var parent_id = $li.find('[name="parents[]"]').val();
					var parent_name = $li.find('[name="parent_names[]"]').val();
					$li.remove();
					if ($('#parents-list li').length === 0) {
						$('#parents-list').append('<li class="list-group-item no-parents">No Parent Selected</li>');
					}

					$('#parent-select option').each(function() {
						var $this = $(this);
						if ($this.text() > parent_name) {
							$('<option value="' + parent_id + '">' + parent_name + '</option>').insertBefore($this);
							$('#parent-select').selectpicker('refresh');
							return false;
						}
					});
					if ($('#parent-select [value=' + parent_id + ']').length === 0) {
						$('#parent-select').append('<option value="' + parent_id + '">' + parent_name + '</option>')
								.selectpicker('refresh');
					}
				});
		});
	})(jQuery);
</script>
@stop
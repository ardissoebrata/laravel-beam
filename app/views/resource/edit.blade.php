@extends('layouts/default')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="page-header">
				<h1>{{ Lang::get('acl.resource.title') }}</h1>
			</div>
			@if (isset($resource))
			{{ Former::populate($resource) }}
			{{ Former::horizontal_open()
						->method('POST')
						->action(URL::action('ResourceController@postEdit'))
						->accept_charset('UTF-8')
						->role('form') }}
			@else
			{{ Former::horizontal_open()
						->method('POST')
						->action(URL::action('ResourceController@postCreate'))
						->accept_charset('UTF-8')
						->role('form') }}
			@endif
			@include('resource/form')
			@if (isset($resource))
			{{ Former::actions(
						Former::primary_submit('acl.save'),
						Former::link('acl.cancel', Session::get('url.referer', URL::action('ResourceController@getIndex'))),
						Former::danger_button('acl.delete')->addClass('pull-right')->data_toggle('modal')->data_target('#delete-modal')
						) }}
			@else
			{{ Former::actions( 
						Former::primary_submit('acl.save'),
						Former::link('acl.cancel', Session::get('url.referer', URL::action('ResourceController@getIndex'))))
			}}
			@endif
			{{ Former::close() }}
		</div>
	</div>
</div>

@if (isset($resource))
{{ Form::open(array('action' => array('ResourceController@postDelete', $resource->id))) }}
{{ Modal::create('delete-modal')
			->header(Lang::get('acl.resource.delete_confirmation.title'))
			->body(Lang::get('acl.resource.delete_confirmation.content'))
			->footer( 
				Button::danger_submit(Lang::get('acl.delete')) .
				Button::normal(Lang::get('acl.cancel'), array('data-dismiss' => 'modal'))
			);
}}
{{ Form::close() }}
@endif

@stop

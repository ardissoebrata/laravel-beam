@extends('layouts/default')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="page-header">
				<h1>{{ Lang::get('acl.resource.title') }}</h1>
			</div>
			{{ Former::horizontal_open()
						->method('POST')
						->action(URL::action('ResourceController@postCreate'))
						->accept_charset('UTF-8')
						->role('form') }}
			{{ Former::text('name', Lang::get('acl.name'))
						->placeholder(Lang::get('acl.name')) }}
			{{ Former::hidden('type', 'other') }}
			{{ Former::select('parent_id', Lang::get('acl.parent'))->options(array('' => Lang::get('acl.resource.noparent')))
						->fromQuery(Resource::otherTypes()->get(), 'name')
						->addClass('selectpicker') }}
			{{ Former::actions( 
						Former::primary_submit('acl.save'),
						Former::link('acl.cancel', URL::action('ResourceController@getIndex'))) 
			}}
			{{ Former::close() }}
		</div>
	</div>
</div>
@stop

@extends('layouts.default')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="page-header">
				<h1>{{ Lang::get('confide.user') }}</h1>
			</div>
			{{ Former::populate($user) }}
			{{ Former::horizontal_open()
						->method('POST')
						->action(URL::action('UserController@postEdit', $user->id))
						->accept_charset('UTF-8')
						->role('form') }}
			{{ Former::text('name', 'confide.name')
						->placeholder('confide.name') }}
			{{ Former::text('username', 'confide.username')
						->placeholder('confide.username') }}
			{{ Former::text('email', 'confide.e_mail')
						->placeholder('confide.e_mail') }}
			{{ Former::password('password', 'confide.password')
						->placeholder('confide.password') }}
			{{ Former::password('password_confirmation', 'confide.password_confirmation')
						->placeholder('confide.password_confirmation') }}
			{{ Former::staticControl('confirmed', 'confide.confirmed') }}
			{{ Former::staticControl('updated_at', 'confide.updated') }}
			{{ Former::staticControl('created_at', 'confide.registered') }}
			{{ Former::actions( 
						Former::primary_submit('confide.save'),
						Former::link('confide.cancel', URL::action('UserController@getIndex'))
			{{ Former::close() }}
		</div>
	</div>
</div>
@stop

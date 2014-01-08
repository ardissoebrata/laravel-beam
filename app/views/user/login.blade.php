@extends('layouts/default')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="page-header">
				<h1>{{ Lang::get('confide.login.title') }}</h1>
			</div>
			{{ Former::horizontal_open()
						->method('POST')
						->action((Confide::checkAction('UserController@do_login')) ?: URL::to('/user/login'))
						->accept_charset('UTF-8')
						->role('form') }}
			{{ Former::text('email', Lang::get('confide.username_e_mail'))
						->placeholder(Lang::get('confide.username_e_mail')); }}
			{{ Former::password('password')
						->placeholder(Lang::get('confide.password')) }}
			{{ Former::checkbox('remember', ' ')->text(Lang::get('confide.login.remember')) }}
			{{ Former::actions( 
						Former::primary_submit(Lang::get('confide.login.submit')),
						Former::link(Lang::get('confide.login.forgot_password'), (Confide::checkAction('UserController@forgot_password')) ?: 'forgot'))}}
			{{ Former::close() }}
		</div>
	</div>
</div>
@stop

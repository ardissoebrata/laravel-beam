@extends('layouts/default')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="page-header">
				<h1>Reset Password</h1>
			</div>
			{{ Former::horizontal_open()
						->method('POST')
						->action((Confide::checkAction('UserController@do_reset_password'))    ?: URL::to('/user/reset'))
						->accept_charset('UTF-8')
						->role('form') }}
			{{ Former::hidden('token', $token) }}
			{{ Former::password('password', Lang::get('confide::confide.password'))
						->placeholder(Lang::get('confide::confide.password')) }}
			{{ Former::password('password_confirmation', Lang::get('confide::confide.password_confirmation'))
						->placeholder(Lang::get('confide::confide.password_confirmation')) }}
			{{ Former::actions( 
							Former::primary_submit(Lang::get('confide::confide.forgot.submit'))
							)}}
			{{ Former::close() }}
		</div>
	</div>
</div>
@stop

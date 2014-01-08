@extends('layouts/default')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="page-header">
				<h1>Sign Up</h1>
			</div>
			{{ Former::horizontal_open()
						->method('POST')
						->action((Confide::checkAction('UserController@store')) ?: URL::to('/user/create'))
						->accept_charset('UTF-8')
						->role('form') }}
			{{ Former::text('username')
						->placeholder(Lang::get('confide::confide.username')) }}
			{{ Former::text('email')
						->placeholder(Lang::get('confide::confide.e_mail'))
						->help(Lang::get('confide::confide.signup.confirmation_required')) }}
			{{ Former::password('password')
						->placeholder(Lang::get('confide::confide.password')) }}
			{{ Former::password('password_confirmation')
						->label(Lang::get('confide::confide.password_confirmation'))
						->placeholder(Lang::get('confide::confide.password_confirmation')) }}
			{{ Former::actions( Former::submit(Lang::get('confide::confide.signup.submit'))->class('btn btn-primary')) }}
			{{ Former::close() }}
		</div>
	</div>
</div>
@stop

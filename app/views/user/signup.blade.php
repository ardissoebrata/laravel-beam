@extends('layouts/default')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="page-header">
				<h1>{{ Lang::get('confide.signup.title') }}</h1>
			</div>
			{{ Former::horizontal_open()
						->method('POST')
						->action((Confide::checkAction('UserController@store')) ?: URL::to('/user/create'))
						->accept_charset('UTF-8')
						->role('form') }}
			{{ Former::text('name', Lang::get('confide.name'))
						->placeholder(Lang::get('confide.name')) }}
			{{ Former::text('username', Lang::get('confide.username'))
						->placeholder(Lang::get('confide.username')) }}
			{{ Former::text('email', Lang::get('confide.e_mail'))
						->placeholder(Lang::get('confide.e_mail'))
						->help(Lang::get('confide.signup.confirmation_required')) }}
			{{ Former::password('password', Lang::get('confide.password'))
						->placeholder(Lang::get('confide.password')) }}
			{{ Former::password('password_confirmation', Lang::get('confide.password_confirmation'))
						->placeholder(Lang::get('confide.password_confirmation')) }}
			{{ Former::actions( Former::primary_submit(Lang::get('confide.signup.submit'))) }}
			{{ Former::close() }}
		</div>
	</div>
</div>
@stop

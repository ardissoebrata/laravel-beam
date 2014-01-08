@extends('layouts/default')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="page-header">
				<h1>{{ Lang::get('confide.forgot.title') }}</h1>
			</div>
			{{ Former::horizontal_open()
						->method('POST')
						->action((Confide::checkAction('UserController@do_forgot_password')) ?: URL::to('/user/forgot'))
						->accept_charset('UTF-8')
						->role('form') }}
			{{ Former::text('email', Lang::get('confide.e_mail'))
						->placeholder(Lang::get('confide.e_mail')); }}
			{{ Former::actions(
						Former::primary_submit(Lang::get('confide.forgot.submit')))}}
			{{ Former::close() }}
		</div>
	</div>
</div>
@stop

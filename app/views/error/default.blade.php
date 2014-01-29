@extends('layouts/default')

@section('styles')
<style>
	.error-template {padding: 40px 15px;text-align: center;}
</style>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="error-template">
			<h1>{{ Lang::get('error.' . $code . '.exclamation') }}</h1>
			<h2>{{ Lang::get('error.' . $code . '.title') }}</h2>
			<div class="error-details">
				{{ Lang::get('error.' . $code . '.message') }}
			</div>
		</div>
	</div>
</div>
@stop
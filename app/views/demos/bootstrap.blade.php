@extends('layouts/default')

@section('styles')
<link rel="stylesheet" href="/css/demos.css" media="screen">
@stop

@section('content')
<div class="row">
	<div class="col-md-3">
		<div class="bs-sidebar hidden-print" role="complementary">
			<ul class="nav bs-sidenav">
				<li class="active"><a href="#glyphicons">Glyphicons</a></li>
				<li><a href="#navbar">Navbar</a></li>
				<li><a href="#buttons">Buttons</a></li>
				<li><a href="#typography">Typography</a></li>
				<li><a href="#tables">Tables</a></li>
				<li><a href="#forms">Forms</a></li>
				<li><a href="#navs">Navs</a></li>
				<li><a href="#indicators">Indicators</a></li>
				<li><a href="#progress">Progress Bars</a></li>
				<li><a href="#containers">Containers</a></li>
				<li><a href="#modals">Modals</a></li>
				<li><a href="#tooltips">Tooltips</a></li>
				<li><a href="#popovers">Popovers</a></li>
				<li><a href="#collapse">Collapse</a></li>
				<li><a href="#carousel">Carousel</a></li>
			</ul>
		</div>
	</div>
	<div class="col-md-9" role="main">
		@include('demos/bootstrap-glyphicons')
		@include('demos/bootstrap-navbar')
		@include('demos/bootstrap-buttons')
		@include('demos/bootstrap-typography')
		@include('demos/bootstrap-tables')
		@include('demos/bootstrap-forms')
		@include('demos/bootstrap-navs')
		@include('demos/bootstrap-indicators')
		@include('demos/bootstrap-progress')
		@include('demos/bootstrap-containers')
		@include('demos/bootstrap-modals')
		@include('demos/bootstrap-tooltips')
		@include('demos/bootstrap-popovers')
		@include('demos/bootstrap-collapse')
		@include('demos/bootstrap-carousel')
	</div>
</div>
@stop

@section('scripts')
<script src="/js/holder.js"></script>
<script src="/js/demos.js"></script>
@stop
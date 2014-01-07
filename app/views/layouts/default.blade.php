<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
			@section('title')
				Laravel Beam
			@show
		</title>
		<meta name="keywords" content="@yield('keywords')" />
		<meta name="author" content="@yield('author')" />
		<!-- Google will often use this as its description of your page/site. Make it good. -->
		<meta name="description" content="@yield('description')" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- Speaking of Google, don't forget to set your site up: http://google.com/webmasters -->
		<meta name="google-site-verification" content="">

		<!-- Dublin Core Metadata : http://dublincore.org/ -->
		<meta name="DC.title" content="Project Name">
		<meta name="DC.subject" content="@yield('description')">
		<meta name="DC.creator" content="@yield('author')">

        <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->

		<link rel="stylesheet" href="/assets/bootstrap/dist/css/bootstrap.css" media="screen">
		<link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.min.css" media="screen">
		<style>
		body {
			position: relative;
			padding: 60px 0;
		}
		</style>
		@yield('styles')
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
		
		<!-- Navbar -->
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li{{ (Request::is('/') ? ' class="active"' : '') }}><a href="{{{ URL::to('/') }}}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
						<li class="dropdown{{ (Request::is('demos/*') ? ' active' : '') }}">
							<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('demos/bootstrap') }}}">
								Demos <span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li{{ (Request::is('demos/bootstrap*') ? ' class="active"' : '') }}><a href="{{{ URL::to('demos/bootstrap') }}}">Bootstrap</a></li>
								<li{{ (Request::is('demos/font-awesome*') ? ' class="active"' : '') }}><a href="{{{ URL::to('demos/font-awesome') }}}">Font Awesome</a></li>
							</ul>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						@if (Auth::guest())
						<li{{ (Request::is('user/login*') ? ' class="active"' : '') }}><a href="{{{ URL::action('UserController@login') }}}">Login</a></li>
						<li{{ (Request::is('user/create*') ? ' class="active"' : '') }}><a href="{{{ URL::action('UserController@create') }}}">Sign Up</a></li>
						@else
						<li class="navbar-text">{{ Auth::user()->username }}</li>
						<li{{ (Request::is('user/logout*') ? ' class="active"' : '') }}><a href="{{{ URL::action('UserController@logout') }}}">Logout</a></li>
						@endif
					</ul>
				</div>
			</div>
		</div>
		<!-- ./ navbar -->

		<div class="container">
			<!-- Notifications -->
			@include('notifications')
			<!-- ./ notifications -->

			<!-- Content -->
			@yield('content')
			<!-- ./ content -->
		</div>

		<!-- Footer -->
		<footer class="clearfix">
			@yield('footer')
		</footer>
		<!-- ./ Footer -->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/assets/jquery/jquery.min.js"><\/script>');</script>
		<script src="/assets/bootstrap/dist/js/bootstrap.js"></script>
		@yield('scripts')

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<!--        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>-->
    </body>
</html>
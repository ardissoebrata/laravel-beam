@extends('layouts/default')

@section('styles')
<style>
	.bs-sidenav {
		margin-top: 30px;
		margin-bottom: 30px;
		padding-top: 10px;
		padding-bottom: 10px;
		text-shadow: 0 1px 0 #fff;
		background-color: #f7f5fa;
		border-radius: 5px;
	}
	
	/*
	 * Side navigation
	 *
	 * Scrollspy and affixed enhanced navigation to highlight sections and secondary
	 * sections of docs content.
	 */

	/* By default it's not affixed in mobile views, so undo that */
	.bs-sidebar.affix {
		position: static;
	}

	/* First level of nav */
	.bs-sidenav {
		margin-top: 30px;
		margin-bottom: 30px;
		padding-top:    10px;
		padding-bottom: 10px;
		text-shadow: 0 1px 0 #fff;
		background-color: #f8f8f8;
		border-radius: 5px;
	}

	/* All levels of nav */
	.bs-sidebar .nav > li > a {
		display: block;
		color: #716b7a;
		padding: 5px 20px;
	}
	.bs-sidebar .nav > li > a:hover,
	.bs-sidebar .nav > li > a:focus {
		text-decoration: none;
		background-color: #e5e3e9;
		border-right: 1px solid #dbd8e0;
	}
	.bs-sidebar .nav > .active > a,
	.bs-sidebar .nav > .active:hover > a,
	.bs-sidebar .nav > .active:focus > a {
		font-weight: bold;
		color: #563d7c;
		background-color: transparent;
		border-right: 1px solid #563d7c;
	}

	/* Nav: second level (shown on .active) */
	.bs-sidebar .nav .nav {
		display: none; /* Hide by default, but at >768px, show it */
		margin-bottom: 8px;
	}
	.bs-sidebar .nav .nav > li > a {
		padding-top:    3px;
		padding-bottom: 3px;
		padding-left: 30px;
		font-size: 90%;
	}

	/* Show and affix the side nav when space allows it */
	@media (min-width: 992px) {
		.bs-sidebar .nav > .active > ul {
			display: block;
		}
		/* Widen the fixed sidebar */
		.bs-sidebar.affix,
		.bs-sidebar.affix-bottom {
			width: 213px;
		}
		.bs-sidebar.affix {
			position: fixed; /* Undo the static from mobile first approach */
			top: 80px;
		}
		.bs-sidebar.affix-bottom {
			position: absolute; /* Undo the static from mobile first approach */
		}
		.bs-sidebar.affix-bottom .bs-sidenav,
		.bs-sidebar.affix .bs-sidenav {
			margin-top: 0;
			margin-bottom: 0;
		}
	}
	@media (min-width: 1200px) {
		/* Widen the fixed sidebar again */
		.bs-sidebar.affix-bottom,
		.bs-sidebar.affix {
			width: 263px;
		}
	}

	/*
	 * Docs sections
	 *
	 * Content blocks for each component or feature.
	 */

	/* Space things out */
	.bs-docs-section + .bs-docs-section {
	  padding-top: 40px;
	}

	/* Janky fix for preventing navbar from overlapping */
	h1[id] {
	  padding-top: 80px;
	  margin-top: -45px;
	}
	
	/*
	* Glyphicons
	*
	* Special styles for displaying the icons and their classes in the docs.
	*/

	.bs-glyphicons {
		padding-left: 0;
		padding-bottom: 1px;
		margin-bottom: 20px;
		list-style: none;
		overflow: hidden;
	}
	.bs-glyphicons li {
		float: left;
		width: 25%;
		height: 115px;
		padding: 10px;
		margin: 0 -1px -1px 0;
		font-size: 12px;
		line-height: 1.4;
		text-align: center;
		border: 1px solid #ddd;
	}
	.bs-glyphicons .glyphicon {
		margin-top: 5px;
		margin-bottom: 10px;
		font-size: 24px;
	}
	.bs-glyphicons .glyphicon-class {
		display: block;
		text-align: center;
		word-wrap: break-word; /* Help out IE10+ with class names */
	}
	.bs-glyphicons li:hover {
		background-color: rgba(86,61,124,.1);
	}

	@media (min-width: 768px) {
		.bs-glyphicons li {
			width: 12.5%;
		}
	}
</style>
@stop

@section('content')
<div class="row">
	<div class="col-md-3">
		@include('demos/bootstrap-affix')
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
<script>
!function ($) {

	$(function(){
		var $window = $(window);
		var $body   = $(document.body);

		var navHeight = $('.navbar').outerHeight(true) + 10;

		$body.scrollspy({
		  target: '.bs-sidebar',
		  offset: navHeight
		});

		$window.on('load', function () {
		  $body.scrollspy('refresh');
		});

		$('.container [href=#]').click(function (e) {
		  e.preventDefault();
		});

		// back to top
		setTimeout(function () {
		  var $sideBar = $('.bs-sidebar');

		  $sideBar.affix({
			offset: {
			  top: function () {
				var offsetTop      = $sideBar.offset().top;
				var sideBarMargin  = parseInt($sideBar.children(0).css('margin-top'), 10);
				var navOuterHeight = $('.bs-docs-nav').height();

				return (this.top = offsetTop - navOuterHeight - sideBarMargin);
			  }
			, bottom: function () {
				return (this.bottom = $('.bs-footer').outerHeight(true));
			  }
			}
		  });
		}, 100);

		setTimeout(function () {
		  $('.bs-top').affix();
		}, 100);

		// tooltip demo
		$('.tooltip-demo').tooltip({
		  selector: "[data-toggle=tooltip]",
		  container: "body"
		});

		$('.tooltip-test').tooltip();
		$('.popover-test').popover();

		$('.bs-docs-navbar').tooltip({
		  selector: "a[data-toggle=tooltip]",
		  container: ".bs-docs-navbar .nav"
		});

		// popover demo
		$("[data-toggle=popover]")
		  .popover();

		// button state demo
		$('#fat-btn')
		  .click(function () {
			var btn = $(this);
			btn.button('loading');
			setTimeout(function () {
			  btn.button('reset');
			}, 3000);
		});
	});
}(jQuery);
</script>
@stop
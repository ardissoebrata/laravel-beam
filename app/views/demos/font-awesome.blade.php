@extends('layouts/default')

@section('styles')
<link rel="stylesheet" href="/css/demos.css" media="screen">
<style>
	.fontawesome-icon-list {
		margin-top:22px
	}
	.fontawesome-icon-list .fa-hover a {
		display:block;
		color:#222;
		line-height:32px;
		height:32px;
		padding-left:10px;
		border-radius:4px
	}
	.fontawesome-icon-list .fa-hover a .fa {
		width:32px;
		font-size:14px;
		display:inline-block;
		text-align:right;
		margin-right:10px
	}
	.fontawesome-icon-list .fa-hover a:hover,
	.fontawesome-icon-list .fa-hover a.selected:hover {
		background-color:#563d7c;
		color:#fff;
		text-decoration:none
	}
	.fontawesome-icon-list .fa-hover a:hover .fa {
		font-size:28px;
		vertical-align:-6px
	}
	.fontawesome-icon-list .fa-hover a:hover .text-muted {
		color:#bbe2d5
	}
	.fontawesome-icon-list .fa-hover a.selected {
		background-color: #e5e3e9;
	}
</style>
@stop

@section('content')
<?php
$categories = array(
	'web-application'	=> 'Web Application Icons',
	'form-control'		=> 'Form Control Icons',
	'currency'			=> 'Currency Icons',
	'text-editor'		=> 'Text Editor Icons',
	'directional'		=> 'Directional Icons',
	'video-player'		=> 'Video Player Icons',
	'brand'				=> 'Brand Icons',
	'medical'			=> 'Medical Icons'
);
?>
<div class="row fontawesome-icon-list">
	<div class="col-md-3">
		<div class="bs-sidebar hidden-print" role="complementary">
			<ul class="nav bs-sidenav">
				@foreach ($categories as $cat_slug => $cat_name)
				<li><a href="#{{ $cat_slug }}">{{ $cat_name }}</a></li>
				@endforeach
			</ul>
		</div>
	</div>
	<div class="col-md-9" role="main">
		@foreach ($categories as $cat_slug => $cat_name)
		<div class="bs-docs-section">
			<div class="page-header">
				<h1 id="{{ $cat_slug }}">{{ $cat_name }}</h1>
			</div>
			<div id="icon-list" class="row">
				<?php
				$cat_icons = array();
				foreach($icons as $icon) 
				{
					if (in_array($cat_name, $icon['categories']))
					{
						$aliases = array();
						if (isset($icon['aliases']))
						{
							$aliases = $icon['aliases'];
						}
						$aliases[] = $icon['id'];
						foreach($aliases as $alias)
						{
							$curr_icon = $icon;
							unset($icon['aliases']);
							$curr_icon['class'] = $alias;
							$curr_icon['is_alias'] = $curr_icon['id'] != $alias;
							$cat_icons[] = $curr_icon;
						}
					}
				}
				usort($cat_icons, function($a, $b) {
					return strcmp($a['class'], $b['class']);
				});
				?>
				@foreach ($cat_icons as $icon)
				<div class="fa-hover col-md-4 col-sm-6">
					<a href="#" title="fa-{{ $icon['class'] }}" data-content="<i class='fa fa-{{ $icon['class'] }} fa-5x'></i> <i class='fa fa-{{ $icon['class'] }} fa-4x'></i> <i class='fa fa-{{ $icon['class'] }} fa-3x'></i> <i class='fa fa-{{ $icon['class'] }} fa-2x'></i> <i class='fa fa-{{ $icon['class'] }} fa-lg'></i>" role="button">
						<i class="fa fa-{{ $icon['class'] }}"></i> fa-{{ $icon['class'] }}{{ ($icon['is_alias']) ? ' <span class="text-muted">(alias)</span>' : '' }}
					</a>
				</div>
				@endforeach
			</div>
		</div>
		@endforeach
	</div>
</div>
@stop

@section('scripts')
<script src="/js/demos.js"></script>
<script>
!function ($) {

	$(function(){
		
		$(".fa-hover > a")
			.popover({
				html: true,
				placement: "auto"
			})
			.on('shown.bs.popover', function () {
				$(this).addClass('selected');
			})
			.on('hidden.bs.popover', function() {
				$(this).removeClass('selected');
			});
	});
}(jQuery);
</script>
@stop
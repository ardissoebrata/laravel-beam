<?php

class DemosController extends BaseController {

	public function getBootstrap()
	{
		return View::make('demos/bootstrap');
	}

	public function getFontAwesome()
	{
		$icons = Symfony\Component\Yaml\Yaml::parse(file_get_contents(public_path('assets/font-awesome/src/icons.yml')));
		return View::make('demos/font-awesome', array(
			'icons'	=> $icons['icons']
		));
	}
	
	public function getIcon($id)
	{
		
	}
}


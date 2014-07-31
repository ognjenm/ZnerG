<?php

class HomeController extends BaseController {

	public function getIndex()
	{
		// Obtain the menu for the website
		$menuOptions = array(
			array('name' => 'About Us', 'level' => '1', 'link' => '#'),
			array('name' => 'Products', 'level' => '1', 'link' => '#'),
			array('name' => 'Services', 'level' => '1', 'link' => '#'),
			array('name' => 'Support', 'level' => '1', 'link' => '#'),
			array('name' => 'Customers', 'level' => '1', 'link' => '#')
		);		
		return View::make('home.index', compact('menuOptions'));
	}

	public function getMain()
	{
		return View::make('home.main');
	}


}
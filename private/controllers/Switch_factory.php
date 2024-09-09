<?php

/**
 * change factory controller
 */
class Switch_factory extends Controller
{
	
	function index($id = '')
	{
		// code...
		if(Auth::access('director')){
			Auth::switch_factory($id);
		}
 		
 		$this->redirect('factories');
 
	}
}

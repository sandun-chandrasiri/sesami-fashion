<?php

/**
 * Sustainability controller
 */
class Sustainability extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];

		if(Auth::access('dataEntryClerk')){
			$this->view('sustainability',[
				'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

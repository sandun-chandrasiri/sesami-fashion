<?php

/**
 * Users_module controller
 */
class Users_module extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Users Module','users_module'];

		if(Auth::access('teamLeader')){
			$this->view('users_module',[
				'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

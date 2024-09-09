<?php

/**
 * login controller
 */
class Signup extends Controller
{
	
	function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

 		$mode = isset($_GET['mode']) ? $_GET['mode'] : '';
		$errors = array();
 		if(count($_POST) > 0)
 		{

 			$user = new User();

 			if($user->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				if(Auth::access('dataEntryClerk')){

 					if($_POST['rank'] == 'director' && $_SESSION['USER']->rank != 'director')
 					{
 						$_POST['rank'] = 'head';
 					}
 					
 					$user->insert($_POST);
 				}

 				$redirect = $mode == 'teamLeaders' ? 'teamLeaders':'users';
 				$this->redirect($redirect);
 			}else
 			{
 				//errors
 				$errors = $user->errors;
 			}
 		}

 		if(Auth::access('dataEntryClerk')){
			$this->view('signup',[
				'errors'=>$errors,
				'mode'=>$mode,
			]);
		}else{
			$this->view('access-denied');
		}
	}
}

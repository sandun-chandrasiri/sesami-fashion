<?php

/**
 * users controller
 */
class Users extends Controller
{
	
	function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$user = new User();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;

 		$factory_id = Auth::getFactory_id();

		$query = "select * from users where factory_id = :factory_id && rank not in ('teamLeader') order by id desc limit $limit offset $offset";
 		$arr['factory_id'] = $factory_id;

 		if(isset($_GET['find']))
 		{
 			$find = '%' . $_GET['find'] . '%';
 			$query = "select * from users where factory_id = :factory_id && rank not in ('teamLeader') && (firstname like :find || lastname like :find) order by id desc limit $limit offset $offset";
 			$arr['find'] = $find;
 		}

		$data = $user->query($query,$arr);
		
		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['User Module','users_module'];
		$crumbs[] = ['Managing Staff','users'];

		if(Auth::access('head')){

			$this->view('users',[
				'rows'=>$data,
				'crumbs'=>$crumbs,
				'pager'=>$pager,
			]);
		}else{
			$this->view('access-denied');
		}
	}
}

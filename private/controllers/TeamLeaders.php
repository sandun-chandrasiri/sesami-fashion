<?php

/**
 * team leader controller
 */
class TeamLeaders extends Controller
{
	
	function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$user = new User();
 		$factory_id = Auth::getFactory_id();
 		
 		$limit = 10;
 		$pager = new Pager($limit);
 		$offset = $pager->offset;

 		$query = "select * from users where factory_id = :factory_id && rank in ('teamLeader') order by id desc limit $limit offset $offset";
 		$arr['factory_id'] = $factory_id;

 		if(isset($_GET['find']))
 		{
 			$find = '%' . $_GET['find'] . '%';
 			$query = "select * from users where factory_id = :factory_id && rank in ('teamLeader') && (firstname like :find || lastname like :find) order by id desc limit $limit offset $offset";
 			$arr['find'] = $find;
 		}

		$data = $user->query($query,$arr);

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['User Module','users_module'];
		$crumbs[] = ['Team Leaders','teamLeaders'];

		if(Auth::access('teamLeader')){
			$this->view('teamLeaders',[
				'rows'=>$data,
				'crumbs'=>$crumbs,
				'pager'=>$pager,
			]);
		}else{
			$this->view('access-denied');
		}
	}
}

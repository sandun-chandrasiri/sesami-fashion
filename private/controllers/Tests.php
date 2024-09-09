<?php


/**
 * tests controller
 */
class Tests extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$tests = new Tests_model();

		$factory_id = Auth::getFactory_id();

		if(Auth::access('head')){

			$query = "select * from tests where factory_id = :factory_id && year(date) = :factory_year order by id desc";
			$arr['factory_id'] = $factory_id;
			$arr['factory_year'] = !empty($_SESSION['FACTORY_YEAR']->year) ? $_SESSION['FACTORY_YEAR']->year : date("Y",time());

			if(isset($_GET['find']))
	 		{
	 			$find = '%' . $_GET['find'] . '%';
	 			$query = "select * from tests where factory_id = :factory_id && (test like :find) && year(date) = :factory_year order by id desc";
	 			$arr['find'] = $find;
	 		}

			$data = $tests->query($query,$arr);
 		}else{

 			$disabled = "disabled = 0 &&";
 			$mytable = "team_teamleaders";
 			if(Auth::getRank() == "manager"){
 				$mytable = "team_managers";
 				$disabled = "";
 			}
 			
 			$query = "select * from tests where $disabled team_id in (select team_id from $mytable where user_id = :user_id && disabled = 0) && year(date) = :factory_year order by id desc";
 			$arr['user_id'] = Auth::getUser_id();
 			$arr['factory_year'] = !empty($_SESSION['FACTORY_YEAR']->year) ? $_SESSION['FACTORY_YEAR']->year : date("Y",time());

 			if(isset($_GET['find']))
	 		{
	 			$find = '%' . $_GET['find'] . '%';
	 			$query = "select * from tests where $disabled team_id in (select team_id from $mytable where user_id = :user_id && disabled = 0) && test like :find && year(date) = :factory_year order by id desc";
	 			$arr['find'] = $find;
	 		}

 			$data = $tests->query($query,$arr);
 
 		}

		$crumbs[] = ['Dashboard',''];
		$crumbs[] = ['Tests','tests'];

		$this->view('tests',[
			'crumbs'=>$crumbs,
			'test_rows'=>$data,
			'unsubmitted'=>get_unsubmitted_test_rows(),
		]);
	}

	 
	
}

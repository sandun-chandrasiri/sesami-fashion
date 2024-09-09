<?php


/**
 * teams controller
 */
class Teams extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$teams = new Teams_model();

		$factory_id = Auth::getFactory_id();
		
		if(Auth::access('head')){

			$query = "SELECT * FROM teams WHERE factory_id = :factory_id AND YEAR(date) = :factory_year ORDER BY id DESC";
			$arr['factory_id'] = $factory_id;
			$arr['factory_year'] = !empty($_SESSION['FACTORY_YEAR']->year) ? $_SESSION['FACTORY_YEAR']->year : date("Y",time());

			if(isset($_GET['find']))
	 		{
	 			$find = '%' . $_GET['find'] . '%';
	 			$query = "SELECT * FROM teams WHERE factory_id = :factory_id AND (teams.team LIKE :find) AND YEAR(date) = :factory_year ORDER BY id DESC";
	 			$arr['find'] = $find;
	 		}

			$data = $teams->query($query,$arr);
 		}else{

 			$team = new Teams_model();
 			$mytable = "team_teamleaders";
 			if(Auth::getRank() == "manager"){
 				$mytable = "team_managers";
 			}
 			
			$query = "SELECT teams.* FROM teams JOIN $mytable ON teams.team_id = $mytable.team_id WHERE ($mytable.user_id = :user_id AND $mytable.disabled = 0 AND YEAR(teams.date) = :factory_year) OR teams.user_id = :user_id";
 			$arr['user_id'] = Auth::getUser_id();
 			$arr['factory_year'] = !empty($_SESSION['FACTORY_YEAR']->year) ? $_SESSION['FACTORY_YEAR']->year : date("Y",time());

 			if(isset($_GET['find']))
	 		{
	 			$find = '%' . $_GET['find'] . '%';
	 			$query = "SELECT teams.team, $mytable.* FROM $mytable JOIN teams ON teams.team_id = $mytable.team_id WHERE ($mytable.user_id = :user_id AND $mytable.disabled = 0 AND teams.team LIKE :find AND YEAR(teams.date) = :factory_year)";
	 			$arr['find'] = $find;
	 		}

 			$data = $team->query($query,$arr);
 
 		}

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Products Module','products_module'];
		$crumbs[] = ['Teams','teams'];

		$this->view('teams',[
			'crumbs'=>$crumbs,
			'rows'=>$data
		]);
	}

	public function add()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$errors = array();
		if(count($_POST) > 0)
 		{

			$teams = new Teams_model();
			if($teams->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$teams->insert($_POST);
 				$this->redirect('teams');
 			}else
 			{
 				//errors
 				$errors = $teams->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Teams','teams'];
		$crumbs[] = ['Add','teams/add'];

		$this->view('teams.add',[
			'errors'=>$errors,
			'crumbs'=>$crumbs,
			
		]);
	}

	public function edit($id = null)
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$teams = new Teams_model();
 		$row = $teams->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('manager') && Auth::i_own_content($row))
 		{

			if($teams->validate($_POST))
 			{
 				
 				$teams->update($id,$_POST);
 				$this->redirect('teams');
 			}else
 			{
 				//errors
 				$errors = $teams->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Teams','teams'];
		$crumbs[] = ['Edit','teams/edit'];

		if(Auth::access('manager') && Auth::i_own_content($row)){

			$this->view('teams.edit',[
				'row'=>$row,
				'errors'=>$errors,
				'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}

	public function delete($id = null)
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

 
		$teams = new Teams_model();
 		$row = $teams->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('manager') && Auth::i_own_content($row))
 		{
 
 			$teams->delete($id);
 			$this->redirect('teams');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Teams','teams'];
		$crumbs[] = ['Delete','teams/delete'];

		if(Auth::access('manager') && Auth::i_own_content($row)){

			$this->view('teams.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

<?php

/**
 * Profile controller
 */
class Profile extends Controller
{
	
	function index($id = '')
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$user = new User();
		$id = trim($id == '') ? Auth::getUser_id() : $id;

		$row = $user->first('user_id',$id);

		$crumbs[] = ['Dashboard',''];
		$crumbs[] = ['profile','profile'];
		if($row){
			$crumbs[] = [$row->firstname,'profile'];
		}

		//get more info depending on tab
		$data['page_tab'] = isset($_GET['tab']) ? $_GET['tab'] : 'info';

		if($data['page_tab'] == 'teams' && $row)
		{
			$team = new Teams_model();
 			$mytable = "team_teamleaders";
 			if($row->rank == "manager"){
 				$mytable = "team_managers";
 			}
 			
			$query = "select * from $mytable where user_id = :user_id && disabled = 0 && year(date) = :factory_year";
			$arr['user_id'] = $id;
			$arr['factory_year'] = !empty($_SESSION['FACTORY_YEAR']->year) ? $_SESSION['FACTORY_YEAR']->year : date("Y",time());
			
			$data['leader_teams'] = $team->query($query,$arr);

			$data['teamLeader_teams'] = array();
			if($data['leader_teams']){
				foreach ($data['leader_teams'] as $key => $arow) {
					// code...
					//$data['student_classes'][] = $team->first('team_id',$arow->team_id); **'student_classes' has been replaced with 'teamLeader_teams' around this comment and 'stud_classes' has been replaced with 'leader_teams' throught the files.
					$data['teamLeader_teams'][] = $team->first('team_id',$arow->team_id);
				}
			}
			
		}else

		if($data['page_tab'] == 'tests' && $row)
		{
			if($row->rank != 'teamLeader'){

				$team = new Teams_model();

				$disabled = "disabled = 0 &&";
	 			$mytable = "team_teamleaders";
	 			if($row->rank == "manager"){
	 				$mytable = "team_managers";
	 				$disabled = "";
	 			}
	 			
   				$tests = new Tests_model();

	 			$query = "select * from tests where $disabled team_id in (select team_id from $mytable where user_id = :user_id && disabled = 0) && year(date) = :factory_year order by id desc";
	 			$arr['user_id'] = Auth::getUser_id();
	 			$arr['factory_year'] = !empty($_SESSION['FACTORY_YEAR']->year) ? $_SESSION['FACTORY_YEAR']->year : date("Y",time());

	 			if(isset($_GET['find']))
		 		{
		 			$find = '%' . $_GET['find'] . '%';
		 			$query = "select * from tests where $disabled team_id in (select team_id from $mytable where user_id = :user_id && disabled = 0) && test like :find && year(date) = :factory_year order by id desc";
		 			$arr['find'] = $find;
		 		}

	 			$data['test_rows'] = $tests->query($query,$arr);


			}else{

				//get all submitted tests
				$marked = array();
				$tests = new Tests_model();

				$query = "select * from answered_tests where user_id = :user_id && submitted = 1 && marked = 1";
				$answered_tests = $tests->query($query,['user_id'=>$id]);

				if(is_array($answered_tests)){
					
					foreach ($answered_tests as $key => $value) {
					
						$test_details = $tests->first('test_id',$answered_tests[$key]->test_id);
						$answered_tests[$key]->test_details = $test_details;

					}

				} 					
			 
				$data['test_rows'] = $answered_tests;
			}
		}

		$data['row'] = $row;
		$data['crumbs'] = $crumbs;
		$data['unsubmitted']= get_unsubmitted_test_rows();

		if(Auth::access('dataEntryClerk') || Auth::i_own_content($row)){
			$this->view('profile',$data);
		}else{
			$this->view('access-denied');
		}
	}

	function edit($id = '')
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}
		$errors = array();

		$user = new User();
		$id = trim($id == '') ? Auth::getUser_id() : $id;
  
		if(count($_POST) > 0 && Auth::access('dataEntryClerk'))
		{

			//something was posted

			//check if passwords exist
			if(trim($_POST['password']) == "")
			{
				unset($_POST['password']);
				unset($_POST['password2']);
			}

			if($user->validate($_POST,$id))
 			{
 				//check for files
 				if($myimage = upload_image($_FILES))
 				{
 					$_POST['image'] = $myimage;
 				}

 				if($_POST['rank'] == 'director' && $_SESSION['USER']->rank != 'director')
				{
					$_POST['rank'] = 'head';
				}

				$myrow = $user->first('user_id',$id);
				if(is_object($myrow)){
					$user->update($myrow->id,$_POST);
				}
 
 				$redirect = 'profile/edit/'.$id;
 				$this->redirect($redirect);
 			}else
 			{
 				//errors
 				$errors = $user->errors;
 			}
		}

		$row = $user->first('user_id',$id);

		$data['row'] = $row;
		$data['errors'] = $errors;

		if(Auth::access('dataEntryClerk') || Auth::i_own_content($row)){
			$this->view('profile-edit',$data);
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

		$errors = array();

		$user = new User();
		$id = trim($id == '') ? Auth::getUser_id() : $id;

		$row = $user->first('user_id',$id);

		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{
 			$user->delete($id);
 			
 			$this->redirect('users_module');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Users Module','users_module'];
		$crumbs[] = ['Teams','teams'];
		$crumbs[] = ['Delete','profile/delete/'.$id];

		

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('profile-delete.view',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
}

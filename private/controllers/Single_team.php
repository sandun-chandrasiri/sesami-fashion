<?php

/**
 * single team controller
 */
class Single_team extends Controller
{
	
	public function index($id = '')
	{
		// code...
		$errors = array();
		if(!Auth::access('teamLeader'))
		{
			$this->redirect('access_denied');
		}

		$teams = new Teams_model();
		$row = $teams->first('team_id',$id);

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Production Module','products_module'];
		$crumbs[] = ['Teams','teams'];

		if($row){
			$crumbs[] = [$row->team,''];
		}

		$limit = 10;
 		$pager = new Pager($limit);
 		$offset = $pager->offset;

		$page_tab = isset($_GET['tab']) ? $_GET['tab'] : 'managers';
		$mng = new Managers_model();

		$results = false;

		if($page_tab == 'managers'){
			
			//display managers
			$query = "select * from team_managers where team_id = :team_id && disabled = 0 order by id desc limit $limit offset $offset";
			$managers = $mng->query($query,['team_id'=>$id]);

			$data['managers'] 		= $managers;
		}else
		if($page_tab == 'teamLeaders'){
			
			//display team leaders
			$query = "select * from team_teamleaders where team_id = :team_id && disabled = 0 order by id desc limit $limit offset $offset";
			$teamLeaders = $mng->query($query,['team_id'=>$id]);

			$data['teamLeaders'] 		= $teamLeaders;
		}else
		if($page_tab == 'tests'){
			
			//display tests
			$query = "select * from tests where team_id = :team_id order by id desc limit $limit offset $offset";
			$tests = $mng->query($query,['team_id'=>$id]);

			$data['tests'] 		= $tests;
		}

		$data['row'] 		= $row;
 		$data['crumbs'] 	= $crumbs;
		$data['page_tab'] 	= $page_tab;
		$data['results'] 	= $results;
		$data['errors'] 	= $errors;
		$data['pager'] 		= $pager;

		$this->view('single-team',$data);
	}

	public function manageradd($id = '')
	{

		$errors = array();
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$teams = new Teams_model();
		$row = $teams->first('team_id',$id);

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Production Module','products_module'];
		$crumbs[] = ['Teams','teams'];

		if($row){
			$crumbs[] = [$row->team,''];
		}

		$page_tab = 'manager-add';
		$mng = new Managers_model();

		$results = false;
		
		if(count($_POST) > 0)
		{

			if(isset($_POST['search'])){

				if(trim($_POST['name']) != ""){

					//find manager
					$user = new User();
					$name = "%".trim($_POST['name'])."%";
					$query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'manager' limit 10";
					$results = $user->query($query,['fname'=>$name,'lname'=>$name,]);
				}else{
					$errors[] = "please type a name to find";
				}
			
			}else
			if(isset($_POST['selected'])){

				//add manager
				$query = "select disabled,id from team_managers where user_id = :user_id && team_id = :team_id limit 1";
  
				if(!$check = $mng->query($query,[
					'user_id' => $_POST['selected'],
					'team_id' => $id,
				])){

					$arr = array();
	 				$arr['user_id'] 	= $_POST['selected'];
	 				$arr['team_id'] 	= $id;
					$arr['disabled'] 	= 0;
					$arr['date'] 		= date("Y-m-d H:i:s");

					$mng->insert($arr);

					$this->redirect('single_team/'.$id.'?tab=managers');

				}else{

					//check if user is active
					if(isset($check[0]->disabled))
					{
						if($check[0]->disabled)
						{

							$arr = array();
			 				$arr['disabled'] 	= 0;
 							$mng->update($check[0]->id,$arr);

							$this->redirect('single_team/'.$id.'?tab=managers');

						}else{

							$errors[] = "that manager already belongs to this team";
						}
					}else{
						$errors[] = "that manager already belongs to this team";
					}
						
				}
 
			}

		}

		$data['row'] 		= $row;
 		$data['crumbs'] 	= $crumbs;
		$data['page_tab'] 	= $page_tab;
		$data['results'] 	= $results;
		$data['errors'] 	= $errors;

		$this->view('single-team',$data);
	}


	public function managerremove($id = '')
	{

		$errors = array();
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$teams = new Teams_model();
		$row = $teams->first('team_id',$id);


		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Production Module','products_module'];
		$crumbs[] = ['Teams','teams'];

		if($row){
			$crumbs[] = [$row->team,''];
		}

		$page_tab = 'manager-remove';
		$mng = new Managers_model();

		$results = false;
		
		if(count($_POST) > 0)
		{

			if(isset($_POST['search'])){

				if(trim($_POST['name']) != ""){

					//find manager
					$user = new User();
					$name = "%".trim($_POST['name'])."%";
					$query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'manager' limit 10";
					$results = $user->query($query,['fname'=>$name,'lname'=>$name,]);
				}else{
					$errors[] = "please type a name to find";
				}
			
			}else
			if(isset($_POST['selected'])){

				//add manager
				$query = "select id from team_managers where user_id = :user_id && team_id = :team_id && disabled = 0 limit 1";
 
				if($row = $mng->query($query,[
					'user_id' => $_POST['selected'],
					'team_id' => $id,
				])){

					$arr = array();
						$arr['disabled'] 	= 1;

					$mng->update($row[0]->id,$arr);

					$this->redirect('single_team/'.$id.'?tab=managers');

				}else{
					$errors[] = "that manager was not found in this team";
				}
 
			}

		}

		$data['row'] 		= $row;
 		$data['crumbs'] 	= $crumbs;
		$data['page_tab'] 	= $page_tab;
		$data['results'] 	= $results;
		$data['errors'] 	= $errors;

		$this->view('single-team',$data);
	}


	public function teamLeaderadd($id = '')
	{

		$errors = array();
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$teams = new Teams_model();
		$row = $teams->first('team_id',$id);

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Production Module','products_module'];
		$crumbs[] = ['Teams','teams'];

		if($row){
			$crumbs[] = [$row->team,''];
		}

		$page_tab = 'teamLeader-add';
		//$stud has been replaced with $leader
		$leader = new TeamLeaders_model();

		$results = false;
		
		if(count($_POST) > 0)
		{

			if(isset($_POST['search'])){

				if(trim($_POST['name']) != ""){

					//find team leader
					$user = new User();
					$name = "%".trim($_POST['name'])."%";
					$query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'teamLeader' limit 10";
					$results = $user->query($query,['fname'=>$name,'lname'=>$name,]);
				}else{
					$errors[] = "please type a name to find";
				}
			
			}else
			if(isset($_POST['selected'])){

				//add team leader
				$query = "select disabled,id from team_teamleaders where user_id = :user_id && team_id = :team_id limit 1";
  
				if(!$check = $leader->query($query,[
					'user_id' => $_POST['selected'],
					'team_id' => $id,
				])){

					$arr = array();
	 				$arr['user_id'] 	= $_POST['selected'];
	 				$arr['team_id'] 	= $id;
					$arr['disabled'] 	= 0;
					$arr['date'] 		= date("Y-m-d H:i:s");

					$leader->insert($arr);

					$this->redirect('single_team/'.$id.'?tab=teamLeaders');

				}else{

					//check if user is active
					if(isset($check[0]->disabled))
					{
						if($check[0]->disabled)
						{

							$arr = array();
			 				$arr['disabled'] 	= 0;
 							$leader->update($check[0]->id,$arr);

							$this->redirect('single_team/'.$id.'?tab=teamLeaders');

						}else{

							$errors[] = "that team leader already belongs to this team";
						}
					}else{
						$errors[] = "that team leader already belongs to this team";
					}
 				}
 
			}

		}

		$data['row'] 		= $row;
 		$data['crumbs'] 	= $crumbs;
		$data['page_tab'] 	= $page_tab;
		$data['results'] 	= $results;
		$data['errors'] 	= $errors;

		$this->view('single-team',$data);
	}


	public function teamLeaderremove($id = '')
	{

		$errors = array();
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$teams = new Teams_model();
		$row = $teams->first('team_id',$id);


		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Production Module','products_module'];
		$crumbs[] = ['Teams','teams'];

		if($row){
			$crumbs[] = [$row->team,''];
		}

		$page_tab = 'teamLeader-remove';
		$leader = new TeamLeaders_model();

		$results = false;
		
		if(count($_POST) > 0)
		{

			if(isset($_POST['search'])){

				if(trim($_POST['name']) != ""){

					//find team leader
					$user = new User();
					$name = "%".trim($_POST['name'])."%";
					$query = "select * from users where (firstname like :fname || lastname like :lname) && rank = 'teamLeader' limit 10";
					$results = $user->query($query,['fname'=>$name,'lname'=>$name,]);
				}else{
					$errors[] = "please type a name to find";
				}
			
			}else
			if(isset($_POST['selected'])){

				//add team leader
				$query = "select id from team_teamleaders where user_id = :user_id && team_id = :team_id && disabled = 0 limit 1";
 
				if($row = $leader->query($query,[
					'user_id' => $_POST['selected'],
					'team_id' => $id,
				])){

					$arr = array();
						$arr['disabled'] 	= 1;

					$leader->update($row[0]->id,$arr);

					$this->redirect('single_team/'.$id.'?tab=teamLeaders');

				}else{
					$errors[] = "that team leader was not found in this team";
				}
 
			}

		}

		$data['row'] 		= $row;
 		$data['crumbs'] 	= $crumbs;
		$data['page_tab'] 	= $page_tab;
		$data['results'] 	= $results;
		$data['errors'] 	= $errors;

		$this->view('single-team',$data);
	}


	public function testadd($id = '')
	{

		$errors = array();
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$teams = new Teams_model();
		$row = $teams->first('team_id',$id);

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Production Module','products_module'];
		$crumbs[] = ['Teams','teams'];

		if($row){
			$crumbs[] = [$row->team,''];
		}

		$page_tab = 'test-add';
		$test_class = new Tests_model();

		$results = false;
		
		if(count($_POST) > 0)
		{

 			if(isset($_POST['test'])){
 
				$arr = array();
 				$arr['test'] 	= $_POST['test'];
 				$arr['description'] 	= $_POST['description'];
 				$arr['team_id'] 	= $id;
				$arr['disabled'] 	= 1;
				$arr['date'] 		= date("Y-m-d H:i:s");

				$test_class->insert($arr);

				$this->redirect('single_team/'.$id.'?tab=tests');
  
			}

		}

		$data['row'] 		= $row;
 		$data['crumbs'] 	= $crumbs;
		$data['page_tab'] 	= $page_tab;
		$data['results'] 	= $results;
		$data['errors'] 	= $errors;

		$this->view('single-team',$data);
	}


	public function testedit($id = '',$test_id = '')
	{

		$errors = array();
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$teams = new Teams_model();
		$tests = new Tests_model();
		
		$row = $teams->first('team_id',$id);
		$test_row = $tests->first('test_id',$test_id);

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Production Module','products_module'];
		$crumbs[] = ['Teams','teams'];

		if($row){
			$crumbs[] = [$row->team,''];
		}

		$page_tab = 'test-edit';
		$test_class = new Tests_model();

		$results = false;
		
		if(count($_POST) > 0)
		{

 			if(isset($_POST['test'])){
 
				$arr = array();
 				$arr['test'] 	= $_POST['test'];
 				$arr['description'] 	= $_POST['description'];
				$arr['disabled'] 	= $_POST['disabled'];

				$test_class->update($test_row->id,$arr);

				$this->redirect('single_team/testedit/'.$id.'/'.$test_id.'?tab=test-edit');
  
			}

		}

		$data['row'] 		= $row;
		$data['test_row'] 		= $test_row;
 		$data['crumbs'] 	= $crumbs;
		$data['page_tab'] 	= $page_tab;
		$data['results'] 	= $results;
		$data['errors'] 	= $errors;

		$this->view('single-team',$data);
	}

	public function testdelete($id = '',$test_id = '')
	{

		$errors = array();
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$teams = new Teams_model();
		$tests = new Tests_model();
		
		$row = $teams->first('team_id',$id);
		$test_row = $tests->first('test_id',$test_id);

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Production Module','products_module'];
		$crumbs[] = ['Teams','teams'];

		if($row){
			$crumbs[] = [$row->team,''];
		}

		$page_tab = 'test-delete';
		$test_class = new Tests_model();

		$results = false;
		
		if(count($_POST) > 0)
		{

 			if(isset($_POST['test'])){
  
				$test_class->delete($test_row->id);

				$this->redirect('single_team/'.$id.'?tab=tests');
  
			}

		}

		$data['row'] 		= $row;
		$data['test_row'] 	= $test_row;
 		$data['crumbs'] 	= $crumbs;
		$data['page_tab'] 	= $page_tab;
		$data['results'] 	= $results;
		$data['errors'] 	= $errors;

		$this->view('single-team',$data);
	}

	
}

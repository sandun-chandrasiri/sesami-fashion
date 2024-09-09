<?php

/**
 * marked controller
 */
class Marked extends Controller
{
	
	function index()
	{
		// code...
		if(!Auth::access('manager'))
		{
			$this->redirect('access-denied');
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


 			$mytable = "team_managers";
  		 
			$query = "select * from $mytable where user_id = :user_id && disabled = 0 && year(date) = :factory_year";
 			$arr['user_id'] = Auth::getUser_id();
 			$arr['factory_year'] = !empty($_SESSION['FACTORY_YEAR']->year) ? $_SESSION['FACTORY_YEAR']->year : date("Y",time());

			if(isset($_GET['find']))
	 		{
	 			$find = '%' . $_GET['find'] . '%';
	 			$query = "select tests.test, {$mytable}.* from $mytable join tests on tests.test_id = {$mytable}.test_id where {$mytable}.user_id = :user_id && {$mytable}.disabled = 0 && tests.test like :find && year(tests.date) = :factory_year";
	 			$arr['find'] = $find;
	 		}

			$arr['leader_teams'] = $tests->query($query,$arr);

			//read all tests from the selectd teams
			$data = array();
			if($arr['leader_teams']){
				foreach ($arr['leader_teams'] as $key => $arow) {
					// code...
 					$query = "select * from tests where team_id = :team_id";
 					$a = $tests->query($query,['team_id'=>$arow->team_id]);
 					if(is_array($a)){
 						$data = array_merge($data,$a);
 					} 					
				}
			}

			
 
 		}

		//get all submitted tests
		$marked = array();
		if (is_array($data) && count($data) > 0) { //
		//if(count($data) > 0){

			$all_tests = array_column($data, 'test_id');
			$all_tests_string = "'".implode("','", $all_tests)."'";
			
				// code...
					$query = "select * from answered_tests where test_id in ($all_tests_string) && submitted = 1 && marked = 1 order by id desc";
					$marked = $tests->query($query);

					if(is_array($marked)){

						foreach ($marked as $key => $value) {
							// code...
							$test_details = $tests->first('test_id',$marked[$key]->test_id);
							$marked[$key]->test_details = $test_details;

						}

					} 					
			
		}else {
		    // Add the following line to log or display the content of $data
		    //echo '<pre>'; print_r($data); echo '</pre>';
		}
					
		$crumbs[] = ['Dashboard',''];
		$crumbs[] = ['To Mark','to_mark'];

		$this->view('marked',[
			'crumbs'=>$crumbs,
			'test_rows'=>$marked
		]);

		
	}
}

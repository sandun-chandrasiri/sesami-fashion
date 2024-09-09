<?php


/**
 * Electricity controller
 */
class Electricity extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$electricity = new Electricity_model();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, month, units FROM electricity WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, month, units FROM electricity WHERE factory_id = :factory_id AND (month LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $electricity->query($query, $arr);

		//$data = $electricity->findAll();

		$electricity = new Electricity_model();
        $monthlyData = $electricity->getMonthlyUnitsData();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Electricity','electricity'];

		if(Auth::access('dataEntryClerk')){
			$this->view('electricity',[
				'crumbs'=>$crumbs,
				'monthlyData'=>$monthlyData,
				'rows'=>$data,
				'pager'=>$pager,
			]);
		}else{
			$this->view('access-denied');
		}
	}

	public function add()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$errors = array();
		if(count($_POST) > 0 && Auth::access('dataEntryClerk'))
 		{

			$electricity = new Electricity_model();
			if($electricity->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$electricity->insert($_POST);
 				$this->redirect('electricity');
 			}else
 			{
 				//errors
 				$errors = $electricity->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Electricity','electricity'];
		$crumbs[] = ['Add','electricity/add'];

		if(Auth::access('dataEntryClerk')){
			$this->view('electricity.add',[
				'errors'=>$errors,
				'crumbs'=>$crumbs,
				
			]);
		}else{
			$this->view('access-denied');
		}
	}

	public function edit($id = null)
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$electricity = new Electricity_model();
 		$row = $electricity->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('dataEntryClerk') && Auth::i_own_content($row))
 		{

			if($electricity->validate($_POST))
 			{
 				
 				$electricity->update($id,$_POST);
 				$this->redirect('electricity');
 			}else
 			{
 				//errors
 				$errors = $electricity->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Electricity','electricity'];
		$crumbs[] = ['Edit','electricity/edit'];

		if(Auth::access('dataEntryClerk') && Auth::i_own_content($row)){

			$this->view('electricity.edit',[
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

 
		$electricity = new Electricity_model();
 		$row = $electricity->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('dataEntryClerk') && Auth::i_own_content($row))
 		{
 
 			$electricity->delete($id);
 			$this->redirect('electricity');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Electricity','electricity'];
		$crumbs[] = ['Delete','electricity/delete'];

		if(Auth::access('dataEntryClerk') && Auth::i_own_content($row)){

			$this->view('electricity.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

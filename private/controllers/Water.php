<?php


/**
 * Water controller
 */
class Water extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$water = new Water_model();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, month, units FROM water WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, month, units FROM water WHERE factory_id = :factory_id AND (month LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $water->query($query, $arr);

		//$data = $water->findAll();

		$water = new Water_model();
        $monthlyData = $water->getMonthlyUnitsData();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Water','water'];

		if(Auth::access('dataEntryClerk')){
			$this->view('water',[
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

			$water = new water_model();
			if($water->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$water->insert($_POST);
 				$this->redirect('water');
 			}else
 			{
 				//errors
 				$errors = $water->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Water','water'];
		$crumbs[] = ['Add','water/add'];

		if(Auth::access('dataEntryClerk')){
			$this->view('water.add',[
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

		$water = new water_model();
 		$row = $water->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('dataEntryClerk') && Auth::i_own_content($row))
 		{

			if($water->validate($_POST))
 			{
 				
 				$water->update($id,$_POST);
 				$this->redirect('water');
 			}else
 			{
 				//errors
 				$errors = $water->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Water','water'];
		$crumbs[] = ['Edit','water/edit'];

		if(Auth::access('dataEntryClerk') && Auth::i_own_content($row)){

			$this->view('water.edit',[
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

 
		$water = new water_model();
 		$row = $water->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('dataEntryClerk') && Auth::i_own_content($row))
 		{
 
 			$water->delete($id);
 			$this->redirect('water');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Water','water'];
		$crumbs[] = ['Delete','water/delete'];

		if(Auth::access('dataEntryClerk') && Auth::i_own_content($row)){

			$this->view('water.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

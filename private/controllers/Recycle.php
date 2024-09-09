<?php


/**
 * Recycle controller
 */
class Recycle extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$recycle = new Recycle_model();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, recycle, description, quantity FROM recycle WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, recycle, description, quantity FROM recycle WHERE factory_id = :factory_id AND (recycle LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $recycle->query($query, $arr);

		//$data = $recycle->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Recycle','recycle'];

		if(Auth::access('dataEntryClerk')){
			$this->view('recycle',[
				'crumbs'=>$crumbs,
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

			$recycle = new recycle_model();
			if($recycle->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$recycle->insert($_POST);
 				$this->redirect('recycle');
 			}else
 			{
 				//errors
 				$errors = $recycle->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Recycle','recycle'];
		$crumbs[] = ['Add','recycle/add'];

		if(Auth::access('dataEntryClerk')){
			$this->view('recycle.add',[
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

		$recycle = new recycle_model();
 		$row = $recycle->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('dataEntryClerk') && Auth::i_own_content($row))
 		{

			if($recycle->validate($_POST))
 			{
 				
 				$recycle->update($id,$_POST);
 				$this->redirect('recycle');
 			}else
 			{
 				//errors
 				$errors = $recycle->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Recycle','recycle'];
		$crumbs[] = ['Edit','recycle/edit'];

		if(Auth::access('dataEntryClerk') && Auth::i_own_content($row)){

			$this->view('recycle.edit',[
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

 
		$recycle = new recycle_model();
 		$row = $recycle->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('dataEntryClerk') && Auth::i_own_content($row))
 		{
 
 			$recycle->delete($id);
 			$this->redirect('recycle');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Recycle','recycle'];
		$crumbs[] = ['Delete','recycle/delete'];

		if(Auth::access('dataEntryClerk') && Auth::i_own_content($row)){

			$this->view('recycle.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

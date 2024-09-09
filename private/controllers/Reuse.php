<?php


/**
 * Reuse controller
 */
class Reuse extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$reuse = new Reuse_model();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, reuse, description, quantity FROM reuse WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, reuse, description, quantity FROM reuse WHERE factory_id = :factory_id AND (reuse LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $reuse->query($query, $arr);

		//$data = $reuse->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Reuse','reuse'];

		if(Auth::access('dataEntryClerk')){
			$this->view('reuse',[
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

			$reuse = new reuse_model();
			if($reuse->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$reuse->insert($_POST);
 				$this->redirect('reuse');
 			}else
 			{
 				//errors
 				$errors = $reuse->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Reuse','reuse'];
		$crumbs[] = ['Add','reuse/add'];

		if(Auth::access('dataEntryClerk')){
			$this->view('reuse.add',[
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

		$reuse = new reuse_model();
 		$row = $reuse->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('dataEntryClerk') && Auth::i_own_content($row))
 		{

			if($reuse->validate($_POST))
 			{
 				
 				$reuse->update($id,$_POST);
 				$this->redirect('reuse');
 			}else
 			{
 				//errors
 				$errors = $reuse->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Reuse','reuse'];
		$crumbs[] = ['Edit','reuse/edit'];

		if(Auth::access('dataEntryClerk') && Auth::i_own_content($row)){

			$this->view('reuse.edit',[
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

 
		$reuse = new reuse_model();
 		$row = $reuse->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('dataEntryClerk') && Auth::i_own_content($row))
 		{
 
 			$reuse->delete($id);
 			$this->redirect('reuse');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Sustainability Module','sustainability'];
		$crumbs[] = ['Reuse','reuse'];
		$crumbs[] = ['Delete','reuse/delete'];

		if(Auth::access('dataEntryClerk') && Auth::i_own_content($row)){

			$this->view('reuse.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

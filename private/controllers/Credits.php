<?php


/**
 * Credits controller
 */
class Credits extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$credits = new Credit();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, name, description, amount, status FROM credit WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, name, description, amount, status FROM credit WHERE factory_id = :factory_id AND (name LIKE :find OR status LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $credits->query($query, $arr);

		//$data = $credits->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Finance Management','finances'];
		$crumbs[] = ['Credits','credits'];

		if(Auth::access('head')){
			$this->view('credits',[
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
		if(count($_POST) > 0 && Auth::access('head'))
 		{

			$credits = new Credit();
			if($credits->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$credits->insert($_POST);
 				$this->redirect('credits');
 			}else
 			{
 				//errors
 				$errors = $credits->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Finance Management','finances'];
		$crumbs[] = ['Credits','credits'];
		$crumbs[] = ['Add','credits/add'];

		if(Auth::access('head')){
			$this->view('credits.add',[
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

		$credits = new Credit();
 		$row = $credits->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{

			if($credits->validate($_POST))
 			{
 				
 				$credits->update($id,$_POST);
 				$this->redirect('credits');
 			}else
 			{
 				//errors
 				$errors = $credits->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Finance Management','finances'];
		$crumbs[] = ['Credits','credits'];
		$crumbs[] = ['Edit','credits/edit'];

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('credits.edit',[
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

 
		$credits = new Credit();
 		$row = $credits->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{
 
 			$credits->delete($id);
 			$this->redirect('credits');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Finance Management','finances'];
		$crumbs[] = ['Credits','credits'];
		$crumbs[] = ['Delete','credits/delete'];

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('credits.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

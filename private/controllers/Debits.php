<?php


/**
 * Debits controller
 */
class Debits extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$debits = new Debit();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, name, description, amount, status FROM debit WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, name, description, amount, status FROM debit WHERE factory_id = :factory_id AND (name LIKE :find OR status LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $debits->query($query, $arr);

		//$data = $debits->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Finance Management','finances'];
		$crumbs[] = ['Debits','debits'];

		if(Auth::access('head')){
			$this->view('debits',[
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

			$debits = new Debit();
			if($debits->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$debits->insert($_POST);
 				$this->redirect('debits');
 			}else
 			{
 				//errors
 				$errors = $debits->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Finance Management','finances'];
		$crumbs[] = ['Debits','debits'];
		$crumbs[] = ['Add','debits/add'];

		if(Auth::access('head')){
			$this->view('debits.add',[
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

		$debits = new Debit();
 		$row = $debits->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{

			if($debits->validate($_POST))
 			{
 				
 				$debits->update($id,$_POST);
 				$this->redirect('debits');
 			}else
 			{
 				//errors
 				$errors = $debits->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Finance Management','finances'];
		$crumbs[] = ['Debits','debits'];
		$crumbs[] = ['Edit','debits/edit'];

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('debits.edit',[
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

 
		$debits = new Debit();
 		$row = $debits->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{
 
 			$debits->delete($id);
 			$this->redirect('debits');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Finance Management','finances'];
		$crumbs[] = ['Debits','debits'];
		$crumbs[] = ['Delete','debits/delete'];

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('debits.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

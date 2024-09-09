<?php


/**
 * Customers controller
 */
class Customers extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$customers = new Customer();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, customer, address, contact FROM customers WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, customer, address, contact FROM customers WHERE factory_id = :factory_id AND (customer LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $customers->query($query, $arr);

		//$data = $customers->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Customers Module','customers_module'];
		$crumbs[] = ['Customers','customers'];

		if(Auth::access('head')){
			$this->view('customers',[
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

			$customers = new Customer();
			if($customers->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$customers->insert($_POST);
 				$this->redirect('customers');
 			}else
 			{
 				//errors
 				$errors = $customers->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Customers Module','customers_module'];
		$crumbs[] = ['Customers','customers'];
		$crumbs[] = ['Add','customers/add'];

		if(Auth::access('head')){
			$this->view('customers.add',[
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

		$customers = new Customer();
 		$row = $customers->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{

			if($customers->validate($_POST))
 			{
 				
 				$customers->update($id,$_POST);
 				$this->redirect('customers');
 			}else
 			{
 				//errors
 				$errors = $customers->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Customers Module','customers_module'];
		$crumbs[] = ['Customers','customers'];
		$crumbs[] = ['Edit','customers/edit'];

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('customers.edit',[
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

 
		$customers = new Customer();
 		$row = $customers->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{
 
 			$customers->delete($id);
 			$this->redirect('customers');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Customers Module','customers_module'];
		$crumbs[] = ['Customers','customers'];
		$crumbs[] = ['Delete','customers/delete'];

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('customers.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

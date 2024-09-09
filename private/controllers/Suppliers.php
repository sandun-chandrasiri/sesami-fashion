<?php


/**
 * Suppliers controller
 */
class Suppliers extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$suppliers = new Supplier();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, supplier, address, contact, rating FROM suppliers WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, supplier, address, contact, rating FROM suppliers WHERE factory_id = :factory_id AND (supplier LIKE :find OR rating LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $suppliers->query($query, $arr);

		//$data = $suppliers->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Suppliers Module','suppliers_module'];
		$crumbs[] = ['Suppliers','suppliers'];

		if(Auth::access('head')){
			$this->view('suppliers',[
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

			$suppliers = new Supplier();
			if($suppliers->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$suppliers->insert($_POST);
 				$this->redirect('suppliers');
 			}else
 			{
 				//errors
 				$errors = $suppliers->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Suppliers Module','suppliers_module'];
		$crumbs[] = ['Suppliers','suppliers'];
		$crumbs[] = ['Add','suppliers/add'];

		if(Auth::access('head')){
			$this->view('suppliers.add',[
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

		$suppliers = new Supplier();
 		$row = $suppliers->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{

			if($suppliers->validate($_POST))
 			{
 				
 				$suppliers->update($id,$_POST);
 				$this->redirect('suppliers');
 			}else
 			{
 				//errors
 				$errors = $suppliers->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Suppliers Module','suppliers_module'];
		$crumbs[] = ['Suppliers','suppliers'];
		$crumbs[] = ['Edit','suppliers/edit'];

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('suppliers.edit',[
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

 
		$suppliers = new Supplier();
 		$row = $suppliers->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{
 
 			$suppliers->delete($id);
 			$this->redirect('suppliers');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Suppliers Module','suppliers_module'];
		$crumbs[] = ['Suppliers','suppliers'];
		$crumbs[] = ['Delete','suppliers/delete'];

		if(Auth::access('manager') && Auth::i_own_content($row)){

			$this->view('suppliers.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

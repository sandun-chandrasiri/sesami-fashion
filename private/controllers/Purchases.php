<?php


/**
 * Purchases controller
 */
class Purchases extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$purchases = new Purchase();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, purchase_name, description, category FROM purchase_orders WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, purchase_name, description, category FROM purchase_orders WHERE factory_id = :factory_id AND (purchase_name LIKE :find OR category LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $purchases->query($query, $arr);

		//$data = $purchases->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Suppliers Module','suppliers_module'];
		$crumbs[] = ['Purchase Orders','purchases'];

		if(Auth::access('manager')){
			$this->view('purchases',[
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

			$purchases = new Purchase();
			if($purchases->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$purchases->insert($_POST);
 				$this->redirect('purchases');
 			}else
 			{
 				//errors
 				$errors = $purchases->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Suppliers Module','suppliers_module'];
		$crumbs[] = ['Purchase Orders','purchases'];
		$crumbs[] = ['Add','purchases/add'];

		if(Auth::access('head')){
			$this->view('purchases.add',[
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

		$purchases = new Purchase();
 		$row = $purchases->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{

			if($purchases->validate($_POST))
 			{
 				
 				$purchases->update($id,$_POST);
 				$this->redirect('purchases');
 			}else
 			{
 				//errors
 				$errors = $purchases->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Suppliers Module','suppliers_module'];
		$crumbs[] = ['Purchase Orders','purchases'];
		$crumbs[] = ['Edit','purchases/edit'];

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('purchases.edit',[
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

 
		$purchases = new Purchase();
 		$row = $purchases->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{
 
 			$purchases->delete($id);
 			$this->redirect('purchases');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Suppliers Module','suppliers_module'];
		$crumbs[] = ['Purchase Orders','purchases'];
		$crumbs[] = ['Delete','purchases/delete'];

		if(Auth::access('manager') && Auth::i_own_content($row)){

			$this->view('purchases.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

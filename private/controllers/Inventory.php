<?php


/**
 * Inventory controller
 */
class Inventory extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$inventory = new Inventory_model();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, inventory, description, quantity, type, inventory_id FROM inventory WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, inventory, description, quantity, type FROM inventory WHERE factory_id = :factory_id AND (inventory LIKE :find OR type LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $inventory->query($query, $arr);

		//$data = $inventory->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Inventory','inventory'];

		if(Auth::access('head') || Auth::access('dataEntryClerk')){
			$this->view('inventory',[
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
		if(count($_POST) > 0 && Auth::access('head') || Auth::access('dataEntryClerk'))
 		{

			$inventory = new Inventory_model();
			if($inventory->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$inventory->insert($_POST);
 				$this->redirect('inventory');
 			}else
 			{
 				//errors
 				$errors = $inventory->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Inventory','inventory'];
		$crumbs[] = ['Add','inventory/add'];

		if(Auth::access('head') || Auth::access('dataEntryClerk')){
			$this->view('inventory.add',[
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

		$inventory = new Inventory_model();
 		$row = $inventory->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('head') || Auth::access('dataEntryClerk') && Auth::i_own_content($row))
 		{

			if($inventory->validate($_POST))
 			{
 				
 				$inventory->update($id,$_POST);
 				$this->redirect('inventory');
 			}else
 			{
 				//errors
 				$errors = $inventory->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Inventory','inventory'];
		$crumbs[] = ['Edit','inventory/edit'];

		if(Auth::access('head') || Auth::access('dataEntryClerk') && Auth::i_own_content($row)){

			$this->view('inventory.edit',[
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

 
		$inventory = new Inventory_model();
 		$row = $inventory->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('head') || Auth::access('dataEntryClerk') && Auth::i_own_content($row))
 		{
 
 			$inventory->delete($id);
 			$this->redirect('inventory');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Inventory','inventory'];
		$crumbs[] = ['Delete','inventory/delete'];

		if(Auth::access('dataEntryClerk') && Auth::i_own_content($row)){

			$this->view('inventory.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

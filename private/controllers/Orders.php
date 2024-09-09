<?php


/**
 * Orders controller
 */
class Orders extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$orders = new Order();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;

		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, order_name, category, description, status, order_id FROM orders WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, order_name, category, description, status FROM orders WHERE factory_id = :factory_id AND (order_name LIKE :find OR status LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $orders->query($query, $arr);
 		
		//$data = $orders->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Customers Module','customers_module'];
		$crumbs[] = ['Orders','orders'];

		if(Auth::access('head')){
			$this->view('orders',[
				'crumbs'=>$crumbs,
				'rows'=>$data,
				'pager'=>$pager,
				//'orderStatusCounts' => $orderStatusCounts,
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
		$data = [];
		
		if(count($_POST) > 0 && Auth::access('head'))
		//if(count($_POST) > 0)
 		{        	

			$orders = new Order();
			if($orders->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				// Debugging
            	var_dump($_POST); // Check if the date is correctly set


 				/*$orders->insert($_POST);
 				$this->redirect('orders');*/

 				try {
				    $orders->insert($_POST);
				    $this->redirect('orders');
				} catch (\Exception $e) {
				    // Handle database insertion error
				    echo 'Error: ' . $e->getMessage();
				}
 			}else
 			{
 				//errors
 				$errors = $orders->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
 		$crumbs[] = ['Customers Module','customers_module'];
		$crumbs[] = ['Orders','orders'];
		$crumbs[] = ['Add','orders/add'];

		if(Auth::access('head')){
			$this->view('orders.add',[
				'errors'=>$errors,
				'crumbs'=>$crumbs,
				'customers' => $data, //
				
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

		$orders = new Order();
 		$row = $orders->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{

			if($orders->validate($_POST))
 			{
 				
 				$orders->update($id,$_POST);
 				$this->redirect('orders');
 			}else
 			{
 				//errors
 				$errors = $orders->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
 		$crumbs[] = ['Customers Module','customers_module'];
		$crumbs[] = ['Orders','orders'];
		$crumbs[] = ['Edit','orders/edit'];

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('orders.edit',[
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

 
		$orders = new Order();
 		$row = $orders->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('head') && Auth::i_own_content($row))
 		{
 
 			$orders->delete($id);
 			$this->redirect('orders');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
 		$crumbs[] = ['Customers Module','customers_module'];
		$crumbs[] = ['Orders','orders'];
		$crumbs[] = ['Delete','orders/delete'];

		if(Auth::access('head') && Auth::i_own_content($row)){

			$this->view('orders.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}

	public function getOrderStatusCounts()
	{
	    $query = "SELECT status, COUNT(*) as count FROM orders WHERE factory_id = :factory_id GROUP BY status";
	    $arr['factory_id'] = $_SESSION['USER']->factory_id;
        $result = $this->query($query, $arr);
	    //$result = $this->query($query);
	    return $result;
	}
 
}

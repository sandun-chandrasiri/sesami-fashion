<?php


/**
 * Products controller
 */
class Products extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$products = new Product();
		$limit = 10;
		$pager = new Pager($limit);
		$offset = $pager->offset;
	 	
		$factory_id = Auth::getFactory_id();

	    $query = "SELECT id, product, description, bom, status FROM products WHERE factory_id = :factory_id ORDER BY id DESC LIMIT $limit OFFSET $offset";
	    $arr['factory_id'] = $factory_id;

	    if (isset($_GET['find'])) {
	        $find = '%' . $_GET['find'] . '%';
	        $query = "SELECT id, product, description, bom, status FROM products WHERE factory_id = :factory_id AND (product LIKE :find OR status LIKE :find) ORDER BY id DESC LIMIT $limit OFFSET $offset";
	        $arr['find'] = $find;
	    }

	    $data = $products->query($query, $arr);

		//$data = $products->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Products Module','products_module'];
		$crumbs[] = ['Products','products'];

		if(Auth::access('manager')){
			$this->view('products',[
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
		if(count($_POST) > 0 && Auth::access('manager'))
 		{

			$products = new Product();
			if($products->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$products->insert($_POST);
 				$this->redirect('products');
 			}else
 			{
 				//errors
 				$errors = $products->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Products Module','products_module'];
		$crumbs[] = ['Products','products'];
		$crumbs[] = ['Add','products/add'];

		if(Auth::access('manager')){
			$this->view('products.add',[
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

		$products = new Product();
 		$row = $products->where('id',$id);

		$errors = array();
		if(count($_POST) > 0 && Auth::access('manager') && Auth::i_own_content($row))
 		{

			if($products->validate($_POST))
 			{
 				
 				$products->update($id,$_POST);
 				$this->redirect('products');
 			}else
 			{
 				//errors
 				$errors = $products->errors;
 			}
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Products Module','products_module'];
		$crumbs[] = ['Products','products'];
		$crumbs[] = ['Edit','products/edit'];

		if(Auth::access('manager') && Auth::i_own_content($row)){

			$this->view('products.edit',[
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

 
		$products = new Product();
 		$row = $products->where('id',$id);

		$errors = array();

		if(count($_POST) > 0 && Auth::access('manager') && Auth::i_own_content($row))
 		{
 
 			$products->delete($id);
 			$this->redirect('products');
 		 
 		}


 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Products Module','products_module'];
		$crumbs[] = ['Products','products'];
		$crumbs[] = ['Delete','products/delete'];

		if(Auth::access('manager') && Auth::i_own_content($row)){

			$this->view('products.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

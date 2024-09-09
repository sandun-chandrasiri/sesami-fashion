<?php

/**
 * Products_module controller
 */
class Products_module extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$products = new Product();
        $productStatusCounts = $products->getProductStatusCounts();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Products Module','products_module'];

		if(Auth::access('manager')){
			//var_dump($productStatusCounts);
			$this->view('products_module',[
				'crumbs'=>$crumbs,
				'productStatusCounts' => $productStatusCounts,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

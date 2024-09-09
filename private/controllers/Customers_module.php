<?php

/**
 * Customers_module controller
 */
class Customers_module extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$orders = new Order();
        $orderStatusCounts = $orders->getOrderStatusCounts();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Customers Module','customers_module'];

		if(Auth::access('manager')){
			//var_dump($orderStatusCounts);
			$this->view('customers_module',[
				'crumbs'=>$crumbs,
				'orderStatusCounts' => $orderStatusCounts,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

<?php

/**
 * Suppliers_module controller
 */
class Suppliers_module extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$purchases = new Purchase();
        $categoryCounts = $purchases->getCategoryCounts();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Suppliers Module','suppliers_module'];

		if(Auth::access('manager')){
			//var_dump($categoryCounts);
			$this->view('suppliers_module',[
				'crumbs'=>$crumbs,
				'categoryCounts' => $categoryCounts,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

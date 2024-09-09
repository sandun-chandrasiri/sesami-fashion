<?php

/**
 * Finances controller
 */
class Finances extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Finance Management','finances'];

		if(Auth::access('head')){

			$credits = new Credit();
        	$totalReceivableAmount = $credits->getTotalReceivableAmount();
        	$totalReceivedAmount = $credits->getTotalReceivedAmount();

        	$debits = new Debit();
        	$totalPayableAmount = $debits->getTotalPayableAmount();
        	$totalPaidAmount = $debits->getTotalPaidAmount();

        	// Debugging statement
        	//var_dump($totalReceivableAmount);

			$this->view('finances',[
				'crumbs'=>$crumbs,
				'totalReceivableAmount' => $totalReceivableAmount,
				'totalReceivedAmount' => $totalReceivedAmount,
				'totalPayableAmount' => $totalPayableAmount,
				'totalPaidAmount' => $totalPaidAmount,

			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

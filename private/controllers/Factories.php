<?php

/**
 * factories controller
 */
class Factories extends Controller
{
	
	public function index()
	{
		// code...
		if(!Auth::logged_in())
		{
			$this->redirect('login');
		}

		$factory = new Factory();
 
		$data = $factory->findAll();

		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Factories','factories'];

		if(Auth::access('director')){
			$this->view('factories',[
				'crumbs'=>$crumbs,
				'rows'=>$data
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
		if(count($_POST) > 0 && Auth::access('director'))
 		{

			$factory = new Factory();
			if($factory->validate($_POST))
 			{
 				
 				$_POST['date'] = date("Y-m-d H:i:s");

 				$factory->insert($_POST);
 				$this->redirect('factories');
 			}else
 			{
 				//errors
 				$errors = $factory->errors;
 			}
 		}

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Factories','factories'];
		$crumbs[] = ['Add','factories/add'];

		if(Auth::access('director')){
			$this->view('factories.add',[
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

		$factory = new Factory();

		$errors = array();
		if(count($_POST) > 0 && Auth::access('director'))
 		{

			if($factory->validate($_POST))
 			{
 				
 				$factory->update($id,$_POST);
 				$this->redirect('factories');
 			}else
 			{
 				//errors
 				$errors = $factory->errors;
 			}
 		}

 		$row = $factory->where('id',$id);

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Factories','factories'];
		$crumbs[] = ['Edit','factories/edit'];

		if(Auth::access('director')){

			$this->view('factories.edit',[
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

		$factory = new Factory();

		$errors = array();

		if(count($_POST) > 0 && Auth::access('director'))
 		{
 
 			$factory->delete($id);
 			$this->redirect('factories');
 		 
 		}

 		$row = $factory->where('id',$id);

 		$crumbs[] = ['Dashboard','home'];
		$crumbs[] = ['Factories','factories'];
		$crumbs[] = ['Delete','factories/delete'];

		if(Auth::access('director')){
			$this->view('factories.delete',[
				'row'=>$row,
	 			'crumbs'=>$crumbs,
			]);
		}else{
			$this->view('access-denied');
		}
	}
	
}

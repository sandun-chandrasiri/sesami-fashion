<?php

/**
 * Authentication class
 */
class Auth
{
	
	public static function authenticate($row)
	{
		// code...
		$_SESSION['USER'] = $row;
	}

	public static function logout()
	{
		// code...
		if(isset($_SESSION['USER']))
		{
			unset($_SESSION['USER']);
		}
	}

	public static function logged_in()
	{
		// code...
		if(isset($_SESSION['USER']))
		{
			return true;
		}

		return false;
	}

	public static function user()
	{
		if(isset($_SESSION['USER']))
		{
			return $_SESSION['USER']->firstname;
		}

		return false;
	}

	public static function __callStatic($method,$params)
	{
		$prop = strtolower(str_replace("get","",$method));

		if(isset($_SESSION['USER']->$prop))
		{
			return $_SESSION['USER']->$prop;
		}

		return 'Unknown';
	}

	public static function switch_factory($id)
	{
		if(isset($_SESSION['USER']) && $_SESSION['USER']->rank == 'director')
		{
			$user = new User();
			$factory = new Factory();

			if($row = $factory->where('id',$id))
			{
				$row = $row[0];
 				$arr['factory_id'] = $row->factory_id;

				$user->update($_SESSION['USER']->id,$arr);
 				$_SESSION['USER']->factory_id = $row->factory_id;
				$_SESSION['USER']->factory_name = $row->factory;

			}
			
			return true;
		}

		return false;
	}


	public static function access($rank = 'teamLeader')
	{
		// code...
		if(!isset($_SESSION['USER']))
		{
			return false;
		}

		$logged_in_rank = $_SESSION['USER']->rank;

		$RANK['director'] 		= ['director','head','manager','dataEntryClerk','teamLeader'];
		$RANK['head'] 			= ['head','manager','dataEntryClerk','teamLeader'];
		$RANK['manager'] 		= ['manager','dataEntryClerk','teamLeader'];
		$RANK['dataEntryClerk'] = ['dataEntryClerk','teamLeader'];
		$RANK['teamLeader'] 	= ['teamLeader'];

		if(!isset($RANK[$logged_in_rank]))
		{
			return false;
		}

		if(in_array($rank,$RANK[$logged_in_rank]))
		{
			return true;
		}

		return false;
	}

	public static function i_own_content($row)
	{

		if(is_array($row))
		{
			$row = $row[0];
		}
		
		if(!isset($_SESSION['USER']))
		{
			return false;
		}

		if(isset($row->user_id)){

			if($_SESSION['USER']->user_id == $row->user_id){
				return true;
			}
		}

		$allowed[] = 'director';
		$allowed[] = 'head';
		$allowed[] = 'dataEntryClerk';

		if(in_array($_SESSION['USER']->rank,$allowed)){
			return true;
		}

		return false;
	}

}
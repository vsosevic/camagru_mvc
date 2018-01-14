<?php

include_once ROOT . '/models/User.php';

/**
* 
*/
class UserController
{
	public function actionIndex()
	{
		require_once(ROOT . '/views/user/index.php');

		return true;
	}


	function __construct()
	{
		# code...
	}
}
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

    public function actionSignUP()
    {
        require_once(ROOT . '/views/user/signup.php');

        return true;
    }

    public function actionLogin()
    {
        require_once(ROOT . '/views/user/login.php');

        return true;
    }

	function __construct()
	{
		# code...
	}
}
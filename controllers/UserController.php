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

    public function actionSignup()
    {
        if (!empty($_POST)) {
            $errmsg = '';
            if (User::username_occupied($_POST['username'])) {
                $errmsg .= 'This usernmae is occupied!';
            }
            if (User::email_occupied($_POST['email'])) {
                $errmsg .= 'This email is occupied!';
            }
        }

        require_once(ROOT . '/views/user/signup.php');

        return true;
    }

    public function actionLogin()
    {
        require_once(ROOT . '/views/user/login.php');

        return true;
    }

    public function actionSettings()
    {
        require_once(ROOT . '/views/user/settings.php');

        return true;
    }

	function __construct()
	{
		# code...
	}
}
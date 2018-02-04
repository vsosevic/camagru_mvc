<?php

/**
* 
*/
class User
{

    public static function username_occupied($username) {

        $db = DBConnection::getConnection();

        $query = $db->prepare('SELECT username FROM users WHERE username=?');
        $query->execute(array($username));
        $row = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($row->username)) {
            return true;
        }

        return false;
    }

    public static function email_occupied($email) {
        $db = DBConnection::getConnection();

        $query = $db->prepare('SELECT email FROM users WHERE email=?');
        $query->execute(array($email));
        $row = $query->fetch(PDO::FETCH_OBJ);

        if (!empty($row->email)) {
            return true;
        }

        return false;
    }

    public static function password_correct($pwd) {

        return true;
    }



	function __construct()
	{
		# code...
	}
}
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

    public static function password_is_complex($pwd) {
        if (strlen($pwd) < 8 ||
            !preg_match("#[0-9]+#", $pwd) ||
            !preg_match("#[a-zA-Z]+#", $pwd)) {

            return false;

        }
        return true;
    }

    public static function string_delete_db_injection($str) {
        $invalid_characters = array("$", "%", "#", "<", ">", "|");
        $str = str_replace($invalid_characters, "", $str);

        return $str;
    }



	function __construct()
	{
		# code...
	}
}
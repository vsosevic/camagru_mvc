<?php

/**
* 
*/
class User
{
    public $email;
    public $username;
    public $active;

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

    public function password_correct($password) {
        $db = DBConnection::getConnection();
        $password_hashed =  hash('whirlpool', $password);

        $q = $db->prepare('SELECT * FROM users WHERE username=? and password=?');
        $q->execute(array($this->username, $password_hashed));
        $row = $q->fetch(PDO::FETCH_OBJ);

        if (!empty($row) && $this->username == $row->username) {
            return true;
        }

        return false;
    }



	function __construct($username)
	{
	    $db = DBConnection::getConnection();
	    $username = self::string_delete_db_injection($username);
	    $q = $db->prepare('SELECT * FROM users WHERE username=?');
	    $q->execute(array($username));
	    $row = $q->fetch(PDO::FETCH_OBJ);

	    if (!empty($row)) {
            $this->username = $row->username;
            $this->email = $row->email;
            $this->active = $row->active;
        }
        else {
	        unset($this);
        }
	}
}
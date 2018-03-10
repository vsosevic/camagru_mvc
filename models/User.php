<?php

/**
* 
*/
class User
{
    public $id_user;
    public $email;
    public $username;
    public $active;
    public $receive_notifications;

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
//        return true;
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

    public static function string_delete_php_injection($str) {
        $invalid_characters = array(";", "(", ")", "{", "}", '"', "'", '$');
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

    public static function generate_reset_key($email) {
        $reset_key = md5('42' . $email); // change hardcoded salt '42' to the constant or smth in the future.

        return $reset_key;
    }

    public static function change_password_by_reset_key($new_password, $reset_key) {
        $reset_key = self::string_delete_db_injection($reset_key);

        $db = DBConnection::getConnection();
        $q = $db->prepare("SELECT * FROM users WHERE md5(concat(\"42\", email))=:reset_key"); // change hardcoded salt '42' to the constant or smth in the future.
        $q->execute(array(':reset_key' => $reset_key));
        $user = $q->fetch(PDO::FETCH_OBJ);

        if (isset($user->email)) {
            $email = $user->email;
            $hashed_passwrod = hash('whirlpool', $new_password);
            $db->query("UPDATE users SET password='$hashed_passwrod' WHERE email='$email'");
            return true;
        }

        return false;
    }

    // !!!!!!! change SESSION to save only id_user. !!!!!!!!!
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
            $this->receive_notifications = $row->receive_notifications;
            $this->id_user = $row->id_user;
        }
        else {
	        unset($this);
        }
	}
}
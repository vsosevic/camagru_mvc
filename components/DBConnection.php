<?php  

/**
*  Class that connects to DB via PDO.
* Returns PDO db object
*/
class DBConnection
{
	private static $connection = null;

	
	public static function getConnection() {
	    if (self::$connection == null) {
			$paramsPath = ROOT . '/config/database.php';
//			include_once (ROOT . '/config/database.php');
			$params = include($paramsPath);
            $test  = "mysql:host={$params['host']};dbname={$params['dbname']}";
//            self::$connection = new PDO("mysql:dbname=$DB_NAME;host=$DB_DSN", $DB_USER, $DB_PASSWORD,
//                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            self::$connection = new PDO("mysql:host={$params['host']};dbname={$params['dbname']}", $params['user'], $params['password']);
	    }

	    return self::$connection;
	}
}

?>
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
			include_once (ROOT . '/config/database.php');
            self::$connection = new PDO("mysql:dbname=$DB_NAME;host=$DB_DSN", $DB_USER, $DB_PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
	    }

	    return self::$connection;
	}
}

?>
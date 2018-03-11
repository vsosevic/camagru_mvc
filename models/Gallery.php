<?php

/**
* 
*/
class Gallery
{

    private $db;

	function __construct()
	{
		$this->db = DBConnection::getConnection();
	}

	public static function getAllImagesUserImages($id_user) {
	    $db = DBConnection::getConnection();
	    $images = $db->query("SELECT * FROM images WHERE id_user='$id_user' ORDER BY image_date DESC")->fetchAll(PDO::FETCH_OBJ);

	    return $images;
    }


}
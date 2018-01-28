<?php

include_once ROOT . '/models/Gallery.php';

/**
* 
*/
class GalleryController
{
	public function actionIndex()
	{
		require_once(ROOT . '/views/gallery/index.php');

		$db = DBConnection::getConnection();
		$q = $db->query('SELECT * FROM users')->fetchAll();
		print_r($q);

		return true;
	}


	function __construct()
	{
		# code...
	}
}
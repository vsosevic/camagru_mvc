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

		$test = DBConnection::getConnection();
		$q = $test->exec('SELECT * FROM users WHERE true', PDO::FETCH_ASSOC);
		return true;
	}


	function __construct()
	{
		# code...
	}
}
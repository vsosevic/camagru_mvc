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

		return true;
	}


	function __construct()
	{
		# code...
	}
}
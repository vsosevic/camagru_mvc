<?php

include_once ROOT . '/models/Gallery.php';

/**
* 
*/
class GalleryController
{

	function __construct()
	{
		# code...
	}

    public function actionIndex()
    {

        require_once(ROOT . '/views/gallery/index.php');

        $db = DBConnection::getConnection();
        $q = $db->query('SELECT * FROM users')->fetchAll();
        print_r($q);

        return true;
    }

    public function actionSaveImage() {
	    $db = DBConnection::getConnection();
	    
        $dataURL = $_POST["image"];
        // the dataURL has a prefix (mimetype+datatype) 
        // that we don't want, so strip that prefix off
        $parts = explode(',', $dataURL);
        $image = $parts[1];
        // Decode base64 image, resulting in an image
        $image = base64_decode($image);
        $imagePath = "files/gallery/" . uniqid() . '.png';
        $id_user = $_SESSION['logged_id_user'];
        $success = file_put_contents($imagePath, $image);
        if ($success) {
            $db->query("INSERT INTO images(id_user, image_path) VALUES('$id_user','$imagePath')");
        }
        $saved_image = $db->query("SELECT id_image FROM images WHERE image_path='$imagePath'")->fetchObject();
        $json_response = array('imagePath' => $imagePath, 'imageID' => $saved_image->id_image);
        print(json_encode($json_response));
    }

}
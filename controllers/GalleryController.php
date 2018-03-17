<?php

include_once ROOT . '/models/Gallery.php';

/**
* 
*/
class GalleryController
{
    private $db;

	function __construct()
	{
		$this->db = DBConnection::getConnection();
	}

    public function actionIndex()
    {
        $images = Gallery::getAllImages();

        include_once (ROOT . '/views/layouts/header.php');
        require_once(ROOT . '/views/gallery/index.php');
        include_once (ROOT . '/views/layouts/footer.php');

        return true;
    }

    public function actionImage($id_image) {
	    if (!empty($id_image)) {
            $image = $this->db->query("SELECT * FROM images WHERE id_image=$id_image")->fetchObject();
        }

        include_once (ROOT . '/views/layouts/header.php');
        require_once(ROOT . '/views/gallery/image.php');
        include_once (ROOT . '/views/layouts/footer.php');
    }

    public function actionSaveImage() {
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
            $this->db->query("INSERT INTO images(id_user, image_path) VALUES('$id_user','/$imagePath')");
        }
        $saved_image = $this->db->query("SELECT id_image FROM images WHERE image_path='/$imagePath'")->fetchObject();
        $json_response = array('imagePath' => $imagePath, 'imageID' => $saved_image->id_image);
        print(json_encode($json_response));
    }

    public function actionImageDelete ($id_image) {
	    $logged_id_user = $_SESSION['logged_id_user'];

	    $image_owner_id_user = $this->db->query("SELECT id_user FROM images WHERE id_image=$id_image")->fetchColumn();

        if (!empty($id_image) && !empty($image_owner_id_user) && !empty($logged_id_user) && $logged_id_user == $image_owner_id_user) {
            $this->db->query("DELETE FROM images WHERE id_image=$id_image")->execute();
        }

        header("Location: /my-camagru");
    }

}
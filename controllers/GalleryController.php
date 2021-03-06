<?php

include_once ROOT . '/models/Gallery.php';
include_once ROOT . '/models/User.php';

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
        $images = Gallery::getImagesWithOffset(0);

        include_once (ROOT . '/views/layouts/header.php');
        require_once(ROOT . '/views/gallery/index.php');
        include_once (ROOT . '/views/layouts/footer.php');

        return true;
    }

    public function actionLoadMoreImages($scrolled_page) {
	    $images = Gallery::getImagesWithOffset($scrolled_page);

	    $response_images = json_encode($images);
        echo $response_images;
    }

    public function actionImage($id_image) {
	    $id_image = (int) $id_image;
        $image = Gallery::getImageByID($id_image);

        include_once (ROOT . '/views/layouts/header.php');

        if (!empty($image)) {
            $comments = Gallery::getCommentsForImage($id_image);
            $number_of_likes = Gallery::getNumberOfLikesForImage($id_image);
            $is_liked = Gallery::imageIsLikedByCurrentUser($id_image);

            require_once(ROOT . '/views/gallery/image.php');
        }
        else {
            echo "There is no image with that ID";
        }

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

    public function actionImageLike($id_image) {

        if (empty($id_image) || empty($_SESSION['logged_id_user'])) {
            echo json_encode(['error' => "Sign in to be able to like"]);
            return;
        }

        $id_user = $_SESSION['logged_id_user'];

        $user_liked_image = Gallery::userLikedImage($id_user, $id_image);

	    if ($user_liked_image) {
	        $this->db->query("DELETE FROM likes WHERE id_user=$id_user AND id_image=$id_image");
        }
        else {
            $this->db->query("INSERT INTO likes(id_user, id_image) VALUES ('$id_user', '$id_image')");
        }

	    $response = [];

	    $response['number_of_likes'] = Gallery::getNumberOfLikesForImage($id_image);
	    $response['like_change'] = $user_liked_image ? -1 : 1; // If liked now it is dislike.

	    echo json_encode($response);
    }

    public function actionImageComment($id_image) {
	    $db = DBConnection::getConnection();
	    $comment_text = $_POST['comment-text'];
	    $image_owner_id = Gallery::getImageOwnerUserId($id_image);
	    $user_image_owner = new User($image_owner_id);
	    $logged_id_user = $_SESSION['logged_id_user'];

	    if (!empty($comment_text) && $user_image_owner && $logged_id_user) {
            $query = $db->prepare("INSERT INTO comments (id_user, id_image, comment) VALUES ('$logged_id_user', '$id_image', ?)");
            $query->execute(array($comment_text));

            if ($user_image_owner->receive_notifications) {
                $email = $user_image_owner->email;
                $username = $user_image_owner->username;
                $image_link = $_SERVER['HTTP_ORIGIN'] . "/gallery/image/$id_image";
                $mailSubject = "New comment for your photo";
                $mailBody = "Hi, $username!\n\n You have a new comment to your image. To see it goto: $image_link";
                mail($email, $mailSubject, $mailBody);
            }
        }

        header("Location: /gallery/image/$id_image");
    }

}
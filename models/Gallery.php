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

	public static function getAllUserImages($id_user) {
	    $db = DBConnection::getConnection();
	    $images = $db->query("SELECT * FROM images WHERE id_user='$id_user' ORDER BY image_date DESC")
            ->fetchAll(PDO::FETCH_OBJ);

	    return $images;
    }

    public static function getAllImages() {
        $db = DBConnection::getConnection();
        $images = $db->query("SELECT * FROM images ORDER BY image_date DESC")
            ->fetchAll(PDO::FETCH_OBJ);

        return $images;
    }

    public static function getImageByID($id_image) {
        $db = DBConnection::getConnection();

        $image = $db->query("SELECT * FROM images WHERE id_image=$id_image")
            ->fetchObject();

        return $image;
    }

    public static function getCommentsForImage($id_image) {
        $db = DBConnection::getConnection();

        $comments = $db->query("SELECT * FROM comments INNER JOIN users ON comments.id_user=users.id_user WHERE id_image=$id_image")
            ->fetchAll(PDO::FETCH_OBJ);

        return $comments;
    }

    public static function getNumberOfLikesForImage($id_image) {
        $db = DBConnection::getConnection();

        $number_of_likes = $db->query("SELECT * FROM likes WHERE id_image=$id_image")
            ->rowCount();

        return $number_of_likes;
    }

    public static function imageIsLikedByCurrentUser($id_image) {
        $db = DBConnection::getConnection();
        $logged_user_id = !empty($_SESSION['logged_id_user']) ? $_SESSION['logged_id_user'] : 0;

        $number_of_likes = $db->query("SELECT * FROM likes WHERE id_user=$logged_user_id AND id_image=$id_image")
            ->rowCount();

        if ($number_of_likes == 0) {
            return false;
        }

        return true;
    }

    public static function userLikedImage($id_user, $id_image) {
	    $db = DBConnection::getConnection();

	    $liked = $db->query("SELECT * FROM likes WHERE id_user=$id_user AND id_image=$id_image")
            ->rowCount();

	    if ($liked == 0) {
	        return false;
        }

        return true;
    }


}
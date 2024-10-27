<?php
require_once 'Model.php';

class Post extends Model {
    private $text, $description;

    public function settext($text) {
        $this->text = $text;
    }

    public function gettext() {
        return $this->text;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public static function getAllPosts($conn) {
        $qry = "SELECT * FROM posts";
        $stmt = mysqli_query($conn, $qry);
        $posts = [];
        while ($row = mysqli_fetch_assoc($stmt)) {
            $post = new Post();
            $post->id = $row['id'];
            $post->settext($row['text']);
            $post->setDescription($row['description']);
            $posts[] = $post;
        }
        return $posts;
    }





public static function getPostById($conn, $id) {
    $qry = "SELECT * FROM posts WHERE id=$id";
    $stmt = mysqli_query($conn, $qry);
    $row = mysqli_fetch_assoc($stmt);
    $post = new Post();
    $post->setId($row['id']);
    $post->settext($row['text']);
    $post->setDescription($row['description']);
    return $post;
}


public function save($conn) {
    if ($this->id) {
        $qry = "UPDATE posts SET text='$this->text', description='$this->description' WHERE id='$this->id'";
        $stmt = mysqli_query($conn, $qry);
    } else {
        $qry = "INSERT INTO posts (text, description) VALUES ('$this->text', '$this->description')";
        $stmt = mysqli_query($conn, $qry);
    }
}



public function delete($conn) {
    $qry = "DELETE FROM posts WHERE id='$this->id'";
    $stmt = mysqli_query($conn, $qry);
    return $stmt;
}

}

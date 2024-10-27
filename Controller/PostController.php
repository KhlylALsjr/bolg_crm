<?php
require_once 'app/Model/Post.php';
require_once 'BaseController.php';

class PostController extends BaseController {
    public function index() {
        $posts = Post::getAllPosts($this->conn);
        require __DIR__ . '/../../view/post/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = new Post();
            $titleError = $this->validate($_POST['title']);
            $descriptionError = $this->validate($_POST['description']);
        
                $post->settext($this->validate($_POST['title']));
                $post->setDescription($this->validate($_POST['description']));
                $post->save($this->conn);
                header('Location: /php/blog_mvc/Posts');
                exit;
            
        }
        require __DIR__ . '/../../view/post/create.php';
    }
    
    public function edit() {
        if (isset($_POST['save'])) {
            $id = $_POST['id'];
            $post = Post::getPostById($this->conn, $id);
            $post->settext($_POST['title']);
            $post->setDescription($_POST['description']);
            $post->save($this->conn);
            header('Location: /php/blog_mvc/Posts');
            exit;
        } else {
            $id = $_GET['id'];
            $post = Post::getPostById($this->conn, $id);
            require __DIR__ . '/../../view/post/edit.php';
        }
    }

    public function delete() {
        if (isset($_POST['yes'])) {
            $id = $_POST['id'];
            $post = Post::getPostById($this->conn, $id);
            $post->delete($this->conn);
            header('Location: /php/blog_mvc/Posts');
            exit;
        } elseif (isset($_POST['no'])) {
            header('Location: /php/blog_mvc/Posts');
            exit;
        } else {
            $id = $_GET['id'];
            $post = Post::getPostById($this->conn, $id);
            require __DIR__ . '/../../view/post/delete.php';
        }
    }
    

    public function show() {
        $id = $_GET['id'];
        $post = Post::getPostById($this->conn, $id);
        require __DIR__ . '/../../view/post/show.php';
    }
}

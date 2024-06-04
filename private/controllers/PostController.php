<?php
require_once 'models/Post.php';

class PostController {
    private $postModel;

    public function __construct($database) {
        $this->postModel = new Post($database);
    }

    public function index() {
        $posts = $this->postModel->getAllPosts();
        require 'views/posts/index.php';
    }

    public function show($id) {
        $post = $this->postModel->getPostById($id);
        require 'views/posts/show.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category_id = $_POST['category_id'];
            $author_id = 1; // Assumindo que o ID do autor está fixo por enquanto

            if ($this->postModel->createPost($title, $content, $category_id, $author_id)) {
                header('Location: index.php');
                exit();
            } else {
                echo 'Erro ao criar o post.';
            }
        } else {
            require 'views/posts/create.php';
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category_id = $_POST['category_id'];

            if ($this->postModel->updatePost($id, $title, $content, $category_id)) {
                header('Location: index.php');
                exit();
            } else {
                echo 'Erro ao atualizar o post.';
            }
        } else {
            $post = $this->postModel->getPostById($id);
            require 'views/posts/edit.php';
        }
    }

    public function delete($id) {
        if ($this->postModel->deletePost($id)) {
            header('Location: index.php');
            exit();
        } else {
            echo 'Erro ao deletar o post.';
        }
    }
}
?>

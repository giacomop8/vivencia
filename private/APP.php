<?php

class APP {
    
    private $conexao;

    public function __construct() {
        
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        if (session_status() == PHP_SESSION_NONE) {

            ini_set('session.gc_maxlifetime', 7200);
            ini_set('session.cookie_lifetime', 7200);
            
            session_start();
        }

        $this->define_constantes();

        include_once 'database/Database.php';

        include_once 'models/BaseModel.php';
        include_once 'models/Category.php';
        include_once 'models/Comment.php';
        include_once 'models/Post.php';
        include_once 'models/User.php';

        include_once 'controllers/BaseModelController.php';
        include_once 'controllers/CategoryController.php';
        include_once 'controllers/CommentController.php';
        include_once 'controllers/PostController.php';
        include_once 'controllers/UserController.php';

        $this->conexao = (new BD())->getConexao();
    }

    private function define_constantes() {
    
        $path = ($_SERVER['SERVER_NAME'] === 'localhost') ? $_SERVER['DOCUMENT_ROOT'].'/vivencia' : $_SERVER['DOCUMENT_ROOT'];
        $url = ($_SERVER['SERVER_NAME'] === 'localhost') ? 'http://localhost/vivencia' : $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];

        if (!defined('PATH')) {
            define('PATH', $path);
        }

        if (!defined('URL')) {
            define('URL', $url);
        }

    }
}
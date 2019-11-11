<?php

/*
 *   Date: 2017-06-01
 * Author: Dawid Yerginyan
 */

class App {

    private $config = [];

    public $db;

    function __construct () {
        $request_uri = $_SERVER['REQUEST_URI'];
        $request_uri = preg_replace("#\?.+#", "", $request_uri);
        define("URL", $request_uri);
        define("ROOT", $_SERVER['DOCUMENT_ROOT']);
    }

    function autoload () {

        spl_autoload_register(function ($class) {
            $class = strtolower($class);
            if (file_exists(ROOT . '/core/classes/' . $class . '.php')) {
                require_once ROOT . '/core/classes/' . $class . '.php';
            }
        });

    }

    function config () {

        $this->_require('/core/config/session.php');
        $this->_require('/core/config/database.php');
        $this->db = new Db($this->config['database']);
    }

    function _require ($path) {

        require ROOT . $path;

    }

    function start () {
        session_name($this->config['sessionName']);
        session_start();
        $route = explode('/', URL);
        $route[1] = strtolower($route[1]);
        if (count($route) === 1 || empty($route[1])) {
            $this->_require('/app/controllers/tasks.php');
            $tasks = new Tasks();
        } else if (file_exists(ROOT . '/app/controllers/' . $route[1] . '.php')){
            $this->_require('/app/controllers/' . $route[1] . '.php');
            $controller = new $route[1]();
        } else {
            $this->_require('/app/controllers/errorpage.php');
            $errorpage = new ErrorPage();
        }
    }
    
}

?>
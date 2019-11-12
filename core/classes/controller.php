<?php

class Controller {

    public $route = [];
    public $model;

    public $args = 0;

    public $params = [];

    function __construct () {
        $this->view('template/header');
        $this->route = explode('/', URL);
        if(empty($this->route[1])){
            $this->route[1] = "tasks";
        }
        $this->args = count($this->route);
        //_pre($this->route, $this->args);
        $this->router();
        $this->view('template/footer');

    }

    function router () {
        if (class_exists($this->route[1])) {
            if ($this->args >= 3) {
                if (method_exists($this, $this->route[2]."Action")) {
                    call_user_func(array($this, $this->route[2]."Action"), $_REQUEST);
                } else {
                    $this->view("errorpage");
                }
            } else {
                call_user_func(array($this, 'indexAction'), $_REQUEST);
            }

        } else {
            $this->view("errorpage");
        }
    }

    function indexAction () {
        $this->listAction();
    }

    function listAction(){
        $params = $_GET;
        $page = 1;
        if(!empty($params["page"])){
            $page = intval($params["page"]);
        }
        $page_url_txt = "?page=#PAGE_ID#";
        if(!empty($params["sort"])){
            $page_url_txt.= "&sort=" . $params["sort"];
        }
        if(!empty($params["direction"])){
            $page_url_txt.= "&direction=" . $params["direction"];
        }
        $result = $this->model()->recordsList($params);
        $records = [];
        $total_count = 0;
        $sort_field = "";
        $sort_direction = "";
        if($result["success"] && !empty($result["records"])){
            $records = $result["records"];
            $total_count = $result["total_count"];
            $sort_field = $result["sort_field"];
            $sort_direction = $result["sort_direction"];
        }
        $page_limit = $this->model()->_list_limit;
        $paging_txt = "";
        if($total_count > $page_limit){
            $paging = new Paging(
                array(
                    "count"=>$total_count,
                    "activePage"=>$page,
                    "pageElCount"=>$page_limit,
                    "paging_name"=>'page',
                    "separator"=>" ",
                    "TempUrl"=>"<li class=\"page-item\"><a class=\"page-link\" href='/".$this->route[1]."$page_url_txt'>#PAGE_NAME#</a></li>",
                    "TempCurrentUrl"=>"<li class=\"page-item active\" aria-current=\"page\"><span class=\"page-link\">#PAGE_ID#<span class=\"sr-only\">(current)</span></span></li>",
                    "next"=>">>",
                    "prev"=>"<<",
                    "first"=>"||<=",
                    "last"=>"=>||"
                )
            );
            $paging_txt = "<nav aria-label=\"...\"><ul class=\"pagination\">" . $paging->getString() . "</ul></div>";
        }
        $this->view($this->route[1].'/index', ["records" => $records, "paging" => $paging_txt, "sort" => $sort_field, "direction" => $sort_direction]);
    }

    function addAction(){
        $record_data = $_POST;
        if(!empty($record_data)){
            $res = $this->model()->insert($record_data);
            if($res["success"]){
                $_SESSION["success_message"] = $res["message"];
                header('Location: /tasks');
                return;
            } else {
                $this->view($this->route[1].'/add', ["form_data" => $record_data, "error_message" => $res["message"]]);
                return;
            }
        }
        $this->view($this->route[1].'/add');
    }

    function editAction(){
        if(!isset($_SESSION["is_logged"])){
            $_SESSION["error_message"] = "У вас не достаточно прав!";
            header('Location: /tasks');
            return;
        }
        $record_data = $_POST;
        if(!empty($record_data)){
            $result = $this->model()->update($record_data);
            if($result["success"]){
                $_SESSION["success_message"] = $result["message"];
                header('Location: /tasks');
                return;
            } else {
                $this->view($this->route[1]."/edit?{$record_data["id"]}", ["form_data" => $record_data, "error_message" => $result["message"]]);
                return;
            }
        } else {
            $params = $_GET;
            if(empty($params["id"])){
                $_SESSION["error_message"] = "ID запись не задан!";
                header('Location: /tasks');
                return;
            }
            $id = intval($params["id"]);
            $result = $this->model()->load($id);
            if(!$result["success"]){
                $_SESSION["error_message"] = $result["message"];
                header('Location: /tasks');
                return;
            }
            $record_data = $result["data"];
            $id = $record_data[$this->model()->_tableIdField];
            unset($record_data[$this->model()->_tableIdField]);
            $record_data["id"] = $id;
            $this->view($this->route[1].'/add', ["form_data" => $record_data]);
        }
    }

    function deleteAction(){
        if(!isset($_SESSION["is_logged"])){
            $_SESSION["error_message"] = "У вас не достаточно прав!";
            header('Location: /tasks');
            return;
        }
        if(empty($_GET["id"])){
            $_SESSION["error_message"] = "ID запись не задан!";
            header('Location: /tasks');
            return;
        }
        $id = intval($_GET["id"]);
        $result = $this->model()->delete($id);
        if($result["success"]){
            $_SESSION["success_message"] = $result["message"];
        } else {
            $_SESSION["error_message"] = $result["message"];
        }
        header('Location: /tasks');
    }

    public function model () {
        if(file_exists(ROOT . '/app/models/' . $this->route[1] . '.php')){
            require_once(ROOT . '/app/models/' . $this->route[1] . '.php');
            return new $this->model;
        }
        $this->view("errorpage", ["error_message" => "Модел не найден!"]);
        exit();
    }

    function view ($path, $data = []) {
        if (is_array($data))
            extract($data);
        require(ROOT . '/app/views/' . $path . '.php');
    }

}

?>
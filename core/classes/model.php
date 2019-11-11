<?php

class Model {

    public $db;
    public $_tablename = "";
    public $_tableIdField = 'id';
    public $_fields = [];
    public $_list_limit = 25;
    public $_totalCount;
    public $_default_sort_field;
    public $_default_sort_order;

    function __construct () {

        global $app;

        $this->db = $app->db;
        
    }

    function recordsList($params){
        $page = 1;
        if(!empty($params["page"])){
            $page = intval($params["page"]);
        }
        $start = ($page -1) * $this->_list_limit;
        $sql_fields = $this->getFieldsSqlTxt();
        $sort_field = $this->_default_sort_field;
        $sort_direction = $this->_default_sort_order;
        if(!empty($params["sort"]) && key_exists($params["sort"], $this->_fields)){
            $sort_field = $params["sort"];
        }
        if(!empty($params["direction"]) && in_array(strtolower($params["direction"]), ["asc", "desc"])){
            $sort_direction = $params["direction"];
        }
        $sql = "SELECT SQL_CAlC_FOUND_ROWS $sql_fields FROM `" . $this->_tablename . "` ORDER BY $sort_field $sort_direction LIMIT $start, " . $this->_list_limit;
        $records = $this->db->q_records($sql);
        $total_count = $this->db->q_result("SELECT FOUND_ROWS() as cnt");
        return ["success" => true, "records" => $records, "total_count" => $total_count, "sort_field" => $sort_field, "sort_direction" => $sort_direction];
    }
    public function beforeInsert($data){
        return $data;
    }

    function insert($data){
        $this->_prepareData($data);
        if(empty($data)){
            return ["success" => false, "message" => "Неправилные данные!"];
        }
        $data = $this->beforeInsert($data);
        $insert_id = $this->db->q_add($this->_tablename, $data);
        if($insert_id > 0){
            return ["success" => true, "message" => "Успешно сохранено!"];
        }
        return ["success" => false, "message" => "Ошибка при добавлении!"];
    }

    public function beforeUpdate($old_data, $data){
        return $data;
    }

    function update($data){
        $id = $data["id"];
        $old_data_res = $this->load($id);
        if(!$old_data_res["success"]){
            return ["success" => false, "message" => $old_data_res["message"]];
        }
        $old_data = $old_data_res["data"];
        $this->_prepareData($data);
        $data = $this->beforeUpdate($old_data, $data);
        if(empty($data)){
            return ["success" => false, "message" => "Неправилные данные!"];
        }
        if(empty($data["id"])){
            return ["success" => false, "message" => "ID не задан!"];
        }
        $id = $data["id"];
        unset($data["id"]);
        $result = $this->db->q_update($this->_tablename, $data, "`" . $this->_tableIdField . "` = $id");
        if($result === false){
            return ["success" => false, "message" => "Ошибка при сохранения!"];
        }
        return ["success" => true, "message" => "Успешно сохранено!"];
    }

    function delete($id){
        if(empty($id)){
            return ["success" => false, "message" => "ID не задан!"];
        }
        $result = $this->db->q_delete($this->_tablename, "`" . $this->_tableIdField . "`=$id");
        if($result === false){
            return ["success" => false, "message" => "Ошибка при удаления!"];
        }
        return ["success" => true, "message" => "Запись успешно удален!"];
    }

    function load($id){
        if(empty($id)){
            return ["success" => false, "message" => "ID не задан!"];
        }
        $sql_fields = $this->getFieldsSqlTxt();
        $sql = "SELECT $sql_fields FROM `" . $this->_tablename . "` WHERE `" . $this->_tableIdField . "`=$id";
        $record_data = $this->db->q_record($sql);
        if(empty($record_data)){
            return ["success" => false, "message" => "Запись не найден!"];
        }
        return ["success" => true, "data" => $record_data];
    }

    function getFieldsSqlTxt (){
        $sql_fields_arr = [];
        foreach($this->_fields as $key => $fields){
            $sql_fields_arr[]= "`$key` AS $key";
        }
        $sql_fields = implode(", ", $sql_fields_arr);
        return $sql_fields;
    }

    function _prepareData(&$data){
        foreach($data as $data_key=>$data_value){
            if(!array_key_exists($data_key, $this->_fields)){
                unset($data[$data_key]);
            }
        }
    }

}

?>
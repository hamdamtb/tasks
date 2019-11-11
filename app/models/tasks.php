<?php

/*
 * Every class derriving from Model has access to $this->db
 * $this->db is a PDO object
 * Has a config in /core/config/database.php
 */
class TasksModel extends Model {
    public $_tablename = "tasks";
    public $_tableIdField = 'id';
    public $_list_limit = 3;
    public $_default_sort_field = "user_name";
    public $_default_sort_order = "ASC";
    public $_fields = [
        "id" => ["type" => "int", "field_type" => "hidden", "checkforadmin" => false],
        "user_name" => ["type" => "varchar", "field_type" => "text", "checkforadmin" => false, "label" => "Имени пользователя"],
        "email" => ["type" => "varchar", "field_type" => "email", "checkforadmin" => false, "label" => "е-mail"],
        "task" => ["type" => "text", "field_type" => "textarea", "checkforadmin" => false, "label" => "Текста задачи"],
        "status" => ["type" => "int", "field_type" => "checkbox", "checkforadmin" => true, "label" => "Решено"],
        "is_edited" => ["type" => "int"]
    ];

    public function beforeInsert($data){
        if(isset($data["status"]) && $data["status"] === "on"){
            $data["status"] = 1;
        } else {
            $data["status"] = 0;
        }
        return $data;
    }

    public function beforeUpdate($old_data, $data){
        if(isset($data["status"]) && $data["status"] === "on"){
            $data["status"] = 1;
        } else {
            $data["status"] = 0;
        }

        if($old_data["task"] != $data["task"]){
            $data["is_edited"] = 1;
        }
        return $data;
    }
}

?>
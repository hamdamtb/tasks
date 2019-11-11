<?php
/**
 * Created by PhpStorm.
 * User: Hamdam
 * Date: 03.11.2019
 * Time: 10:55
 */

class Db {

    protected $link = null;
    public $config = array();

    public function __construct($dbConfig){
        $this->config = $dbConfig;
        $this->link = new mysqli($dbConfig["HOSTNAME"], $dbConfig["USERNAME"], $dbConfig["PASSWORD"], $dbConfig["DB_NAME"], $dbConfig["DB_PORT"]);
        if(!$this->link){
            echo "Извините, на Нашем сайте идет реконстукция!";
            die();
        }else{
            $this->link->query("SET NAMES ".$dbConfig["CHARSET"].";");
        }
    }

    public function q_records($sql){
        $result = $this->q($sql);
        $records = array();
        if($result){
            while($record = $result->fetch_assoc()){
                $records[] = $record;
            }
        }
        return $records;
    }

    public function q_record($sql){
        $result = $this->q($sql);
        $record = false;
        if($result){
            $record = $result->fetch_assoc();
        }
        return $record;
    }

    public function q_result($sql){
        $result = $this->q($sql);
        $res = '';
        if($result){
            $record = $result->fetch_assoc();
            if (empty($record)) return false;
            $res = current($record);
        }
        return $res;
    }


    public function q_add($table, $record){
        $sqlInsert = array();
        foreach($record as $key=>$value){
            $value = $this->escape_string($value);
            $sqlInsert[] = "`$key` = $value";
        }
        $sql = "INSERT INTO `$table` SET ".implode(",", $sqlInsert).";";
        $result =  $this->q($sql);
        if($result){
            return $this->link->insert_id;
        }
        return 0;
    }

    public function q_add_records($table, $records){
        if(count($records)==0){
            return false;
        }
        $rec = $records[0];
        $sqlKeys = array();
        foreach($rec as $key=>$value){
            $sqlKeys[] = "`$key`";
        }

        $sqlValues = array();
        foreach($records as $record){
            $sqlValue = array();
            foreach($record as $key=>$value){
                $sqlValue[] = $this->escape_string($value);
            }
            $sqlValues[]  = "(".implode(",", $sqlValue).")";
        }

        $sql = "INSERT INTO `$table`(".implode(",", $sqlKeys).") VALUES".implode(",", $sqlValues).";";
        return $this->q($sql);
    }

    public function q_update($table, $record, $where){
        $sqlInsert = array();
        foreach($record as $key=>$value){
            $value = $this->escape_string($value);
            $sqlInsert[] = "`$key` = $value";
        }
        if($where!="") $where = "WHERE $where";
        $sql = "UPDATE `$table` SET ".implode(",", $sqlInsert)." $where;";
        return $this->q($sql);
    }

    public function q_delete($table, $where){
        $sql = "DELETE FROM `$table` WHERE $where;";
        return $this->q($sql);
    }

    public function escape_string($value){
        if (get_magic_quotes_gpc()){
            $value = stripslashes($value);
        }
        return "'" . $this->link->escape_string($value) . "'";
    }
    public function q($sql){
        $result = $this->link->query($sql);
        if(!$result){
            return false;
        }
        return $result;
    }

    public function insert_id(){
        return $this->link->insert_id;
    }

    public function __destruct(){
        $this->link->close();
    }

    public function filter_sql($string)
    {
        if (is_numeric($string) || $string === null || is_bool($string)) {
            return $string;
        }
        if (get_magic_quotes_gpc()) {
            $string = stripslashes($string);
        }

        return $string;
    }
}
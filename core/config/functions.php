<?php
/**
 * Created by PhpStorm.
 * User: Hamdam
 * Date: 05.11.2019
 * Time: 11:34
 */

function _pre(){
    $args = func_get_args();
    echo "<br/>";
    echo "<br/>";
    echo "/*<pre>";
    foreach($args as $ar){
        print_r($ar);
    }
    echo "</pre>*/";
}

function make_th($caption, $field_name, $sort_field, $sort_direction, $page){
    $th = "<th scope=\"col\">";
    $dir_cls = "";
    $url_params_txt = "";
    if($page > 0){
        $url_params_txt.="?page=$page";
    }
    if(!empty($sort_field)){
        if(empty($url_params_txt)){
            $url_params_txt.="?sort=$field_name";
        } else {
            $url_params_txt.="&sort=$field_name";
        }
    }
    if(!empty($sort_direction)){
        $direction = "asc";
        if(strtolower($sort_direction) === "asc"){
            $direction = "desc";
            $dir_cls = " <i class=\"fas fa-sort-alpha-down\"></i>";
        }
        if(strtolower($sort_direction) === "desc"){
            $dir_cls = " <i class=\"fas fa-sort-alpha-up\"></i>";
        }

        if(empty($url_params_txt)){
            $url_params_txt.="?direction=$direction";
        } else {
            $url_params_txt.="&direction=$direction";
        }
    }
    $href = URL.$url_params_txt;
    $th.="<a href=\"$href\">$caption";
    if($field_name === $sort_field){
        $th.=$dir_cls;
    }
    $th.="</a></th>";
    return $th;
};
<?php


class Paging {
    private $result = "";
    function __construct($config){
        $cnt = intval($config['count']);
        $pElCount = intval($config['pageElCount']);
        $pages = ($cnt%$pElCount==0)? $cnt/$pElCount: intval($cnt/$pElCount)+1;
        //echo $config['activePage']%10;
        $startPages = $config['activePage'] - $config['activePage']%10+1;
        if($config['activePage']%10==0 && $config['activePage']>1){
            $startPages = $config['activePage']-9;
        }
        $items = array();
        $endPages = $startPages+10;
        $nextString = false;
        if($endPages>$pages){
            $endPages = $pages+1;
        }else{
            $nextString = true;
        }
        if($startPages>10){
            $items[] = str_replace(array("#PAGE_ID#", "#PAGE_NAME#"), array(1, isset($config['first'])?$config['first']:"||<="), $config['TempUrl']);
            $items[] = str_replace(array("#PAGE_ID#", "#PAGE_NAME#"), array($startPages-10, isset($config['prev'])?$config['prev']:"<<"), $config['TempUrl']);
        }
        for($i=$startPages; $i<$endPages; $i++){
            if($i==$config['activePage']){
                $items[] = str_replace(array("#PAGE_ID#", "#PAGE_NAME#"), array($i, $i), $config['TempCurrentUrl']);
            }else{
                $items[] = str_replace(array("#PAGE_ID#", "#PAGE_NAME#"), array($i, $i), $config['TempUrl']);
            }
        }
        if($nextString){
            $items[] = str_replace(array("#PAGE_ID#", "#PAGE_NAME#"), array($startPages+10, isset($config['next'])?$config['next']:">>"), $config['TempUrl']);
            $items[] = str_replace(array("#PAGE_ID#", "#PAGE_NAME#"), array($pages, isset($config['last'])?$config['last']:"=>||"), $config['TempUrl']);
        }

        $this->result = implode($config['separator'], $items);
    }
    function getString(){
        return $this->result;
    }
}

?>

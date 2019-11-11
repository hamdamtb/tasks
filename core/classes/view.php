<?php
/**
 * Created by PhpStorm.
 * User: Hamdam
 * Date: 03.11.2019
 * Time: 10:45
 */

class View
{
    public function render($data = [], $exit = true)
    {
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public function renderError($message = "Error", $exit = true)
    {
        $this->render(['success'=>false, 'message'=>$message], $exit);
    }

    public function renderData($data, $exit = true)
    {
        $this->render(['success'=>true, 'data'=>$data], $exit);
    }

    public function renderRecords($records, $totalCount = 0, $start=0, $limit=0, $exit = true)
    {
        if($totalCount === 0) $totalCount = count($records);
        $this->render([
            'success'=>true,
            'total'=>$totalCount,
            'start'=>$start,
            'limit'=>$limit,
            'records'=>$records
        ], $exit);
    }

    public function renderRecordsExt($records, $totalCount = 0, $start=0, $limit=0, $extData = [], $exit = true)
    {
        if($totalCount === 0) $totalCount = count($records);
        $extData['success'] = true;
        $extData['total'] = $totalCount;
        $extData['start'] = $start;
        $extData['limit'] = $limit;
        $extData['records'] = $records;
        $this->render($extData, $exit);
    }

    public function renderSuccess($message = "", $exit = true)
    {
        $this->render(['success'=>true, 'message'=>$message], $exit);
    }
}
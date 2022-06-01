<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use App\SalesWorkMemo;
use App\Company;
use Exception;
use Config;

class SalesWorkDiaryRepository
{
    public function lists($params, $user = array()) {
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? $params['offset'] : 10;
        $workMemo = SalesWorkMemo::where(function ($query) use ($params) {
            $keyword = isset($params['keyword']) ? trim($params['keyword']) : '';
            $query->orWhere('SubName', 'like', "%$keyword%")
                ->orWhere('SalesName', 'like', "%$keyword%")
                ->orWhere('WorkMemo', 'like', "%$keyword%");
            })
            ->orderBy('CreateDate', 'desc')
            ->skip(($nowPage-1) * $offset)
            ->take($offset)
            ->get();
        if(isset($workMemo[0])) {
            return $workMemo;
        }
        return [];
    }

    public function listsAmount($params, $user = array()) {
        $amount = SalesWorkMemo::where(function ($query) use ($params) {
            $keyword = isset($params['keyword']) ? trim($params['keyword']) : '';
            $query->orWhere('SubName', 'like', "%$keyword%")
                ->orWhere('SalesName', 'like', "%$keyword%")
                ->orWhere('WorkMemo', 'like', "%$keyword%");
            })
            ->count();
        return $amount;
    }

    public function create($params) {
        if(isset($params['SubId']) == false || trim($params['SubId']) == '')
            throw new Exception('SubId required');
        if(isset($params['VisitDate']) == false || trim($params['VisitDate']) == '')
            throw new Exception('VisitDate required');
        if(isset($params['WorkMemo']) == false || trim($params['WorkMemo']) == '')
            throw new Exception('WorkMemo required');

        $company = Company::where('UserId', '=', $params['SubId'])
            ->first();
        if(isset($company->id) == false)
            throw new Exception('車行不存在');

        $nowDate = date('Y-m-d');
        $nowTime = date('H:i:s');
        $count = SalesWorkMemo::where('CreateDate', 'like', "$nowDate%")
            ->count();
        $fileName = $nowDate. '-'. str_pad($count, 5, '0', STR_PAD_LEFT);

        $salesWorkDiary = new SalesWorkMemo();
        $salesWorkDiary->SubId = $params['SubId'];
        $salesWorkDiary->SubName = $company->UserName;
        $salesWorkDiary->VisitDate = $params['VisitDate'];
        $salesWorkDiary->SalesName = $params['SalesName'];
        $salesWorkDiary->WorkMemo = $params['WorkMemo'];
        $salesWorkDiary->RandomName = $fileName;
        $salesWorkDiary->CreateDate = "$nowDate $nowTime";
        $salesWorkDiary->save();

        $path = env('SALES_WORK_MEMO_PATH', '');
        if(is_dir($path) == true) {
            $fileContentArr = [
                $params['SubId'],
                $company->UserName,
                $params['VisitDate'],
                $params['WorkMemo']
            ];
            Storage::disk('salesmemo')->put($fileName. '.csv', implode(',', $fileContentArr));
        }
    }

    public function getById($id) {
        $diary = SalesWorkMemo::where('WorkMemoID', '=', $id)
            ->first();
        if(isset($diary->WorkMemoID) == false) {
            throw new Exception('日誌不存在');
        }
        return $diary;
    }

    public function updateById($id, $params, $admin) {
        $salesWorkDiary = SalesWorkMemo::where('WorkMemoID', '=', $id)
            ->first();
        if(isset($salesWorkDiary->WorkMemoID) == false) {
            throw new Exception('日誌不存在');
        }

        $salesWorkDiary->SubId = $params['SubId'];
        $salesWorkDiary->SubName = $params['SubName'];
        $salesWorkDiary->VisitDate = $params['VisitDate'];
        $salesWorkDiary->SalesName = $params['SalesName'];
        $salesWorkDiary->WorkMemo = $params['WorkMemo'];
        $salesWorkDiary->save();
    }
}

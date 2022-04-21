<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use App\Repositories\SalesWorkDiaryRepository;
use Session;
use Exception;

class SalesWorkDiaryController extends Controller
{
    public function index(Request $request) {
        $params = $request->all();
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? $params['offset'] : 10;
        $admin = Session::get('admin');
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $salesWorkDiaryRepository = new SalesWorkDiaryRepository();
            $result['diaries'] = $salesWorkDiaryRepository->lists($params);
            $result['amount'] = $salesWorkDiaryRepository->listsAmount($params);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        unset($params['nowPage']);
        return view('admin/sales/diary/index', ['adm' => $admin, 'result' => $result, 'offset' => $offset, 'nowPage' => $nowPage, 'params' => $params]);
    }
}

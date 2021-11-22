<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\RecordRepository;
use App\Repositories\AccountRepository;
use Session;
use Exception;

class RecordController extends Controller
{
    /*
    public function index(Request $request) {
        return view('account.record.search');
    }
     */
    public function caseScheduleListPage(Request $request) {
        return view('user.case.schedule');
    }

    public function caseScheduleList(Request $request) {
        $params = $request->all();
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? $params['offset'] : 10;
        $user = Session::get('user');
        $params['userId'] = $user->id;
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $recordRepository = new RecordRepository();
            $result['records'] = $recordRepository->caseScheduleList($user, $params);
            $result['amount'] = $recordRepository->caseScheduleListAmount($user, $params);
            $result['nowPage'] = $nowPage;
            $result['offset'] = $offset;
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return json_encode($result);
    }
}

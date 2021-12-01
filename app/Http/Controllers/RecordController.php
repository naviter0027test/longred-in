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
    public function caseSchedulePage(Request $request) {
        return view('user.case.schedule');
    }

    //案件歸檔進度
    public function caseSchedule(Request $request) {
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

    public function caseSearchPage(Request $request) {
        return view('user.case.search');
    }

    //案件查詢
    public function caseSearch(Request $request) {
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
            $result['records'] = $recordRepository->caseSearchList($user, $params);
            $result['amount'] = $recordRepository->caseSearchListAmount($user, $params);
            $result['nowPage'] = $nowPage;
            $result['offset'] = $offset;
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return json_encode($result);
    }

    public function caseCustPayPage(Request $request) {
        return view('user.case.pay');
    }

    //撥款
    public function caseCustPay(Request $request) {
        $params = $request->all();
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? $params['offset'] : 10;
        $user = Session::get('user');
        $params['userId'] = $user->id;
        $params['orderName'] = 'CustAllowDenyTime';
        $params['orderBy'] = 'asc';
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $recordRepository = new RecordRepository();
            $result['records'] = $recordRepository->caseSearchList($user, $params);
            $result['amount'] = $recordRepository->caseSearchListAmount($user, $params);
            $result['nowPage'] = $nowPage;
            $result['offset'] = $offset;
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return json_encode($result);
    }

    public function caseInsurancePage(Request $request) {
        return view('user.case.insurance');
    }

    //設定 保險
    public function caseInsurance(Request $request) {
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
            $result['records'] = $recordRepository->caseSearchList($user, $params);
            $result['amount'] = $recordRepository->caseSearchListAmount($user, $params);
            $result['nowPage'] = $nowPage;
            $result['offset'] = $offset;
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return json_encode($result);
    }

    public function casePreorderPage(Request $request) {
        return view('user.case.preorder');
    }

    //預購車
    public function casePreorder(Request $request) {
        $params = $request->all();
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? $params['offset'] : 10;
        $user = Session::get('user');
        $params['userId'] = $user->id;
        $params['orderBy'] = 'asc';
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $recordRepository = new RecordRepository();
            $result['records'] = $recordRepository->caseSearchList($user, $params);
            $result['amount'] = $recordRepository->caseSearchListAmount($user, $params);
            $result['nowPage'] = $nowPage;
            $result['offset'] = $offset;
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return json_encode($result);
    }

    public function caseCustomerPage(Request $request) {
        return view('user.case.customer');
    }

    //客戶繳款資訊
    public function caseCustomer(Request $request) {
        $params = $request->all();
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? $params['offset'] : 10;
        $user = Session::get('user');
        $params['userId'] = $user->id;
        $params['orderBy'] = 'asc';
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $recordRepository = new RecordRepository();
            $result['records'] = $recordRepository->caseSearchList($user, $params);
            $result['amount'] = $recordRepository->caseSearchListAmount($user, $params);
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

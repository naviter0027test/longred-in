<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use App\Repositories\SalesWorkDiaryRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
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

    public function edit(Request $request, $id) {
        $admin = Session::get('admin');
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $params = [
                'nowPage' => 1,
                'offset' => 9999,
            ];
            $companyRepository = new CompanyRepository();
            $result['companies'] = $companyRepository->lists($params);
            $userRepository = new UserRepository();
            $result['users'] = $userRepository->lists($params);
            $salesWorkDiaryRepository = new SalesWorkDiaryRepository();
            $result['diary'] = $salesWorkDiaryRepository->getById($id);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin/sales/diary/edit', ['adm' => $admin, 'result' => $result]);
    }

    public function update(Request $request, $id) {
        $admin = Session::get('admin');
        $params = $request->all();
        $files = [];
        $result = [
            'result' => true,
            'msg' => 'success',
        ];

        try {
            $salesWorkDiaryRepository = new SalesWorkDiaryRepository();
            $salesWorkDiaryRepository->updateById($id, $params, $admin);
        } catch (Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.proccessResult', ['adm' => $admin, 'result' => $result]);
    }
}

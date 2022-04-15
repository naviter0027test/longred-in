<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use App\Repositories\SalesWorkDiaryRepository;
use Session;
use Exception;

class SalesWorkDiaryController extends Controller
{
    public function createPage(Request $request) {
        return view('user.sales.create');
    }

    public function create(Request $request) {
        $params = $request->all();
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        $user = Session::get('user');
        $privileges = Session::get('seePrivileges');
        try {
            $params['SalesName'] = $user->UserName;
            $salesWorkDiaryController = new SalesWorkDiaryRepository();
            $salesWorkDiaryController->create($params);
            //$result['params'] = $params;
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return json_encode($result);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use App\Repositories\CompanyRepository;
use Session;
use Exception;

class CompanyController extends Controller
{
    public function indexPage(Request $request) {
        return view('user.company.index');
    }

    public function index(Request $request) {
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
            $companyRepository = new CompanyRepository();
            $result['companies'] = $companyRepository->listsByApi($user, $params);
            $result['amount'] = $companyRepository->listsByApiAmount($user, $params);
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

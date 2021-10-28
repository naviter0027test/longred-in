<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use App\Repositories\CompanyRepository;
use Session;
use Exception;

class CompanyController extends Controller
{
    public function index(Request $request) {
        $admin = Session::get('admin');
        $params = $request->all();
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset =  isset($params['offset']) ? $params['offset'] : 10;
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $companyRepository = new companyRepository();
            $result['companies'] = $companyRepository->lists($params);
            $result['amount'] = $companyRepository->listsAmount($params);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.company.index', ['adm' => $admin, 'result' => $result, 'offset' => $offset, 'nowPage' => $nowPage]);
    }
}

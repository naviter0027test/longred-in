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
        return view('admin.company.index', ['adm' => $admin, 'result' => $result, 'offset' => $offset, 'nowPage' => $nowPage, 'params' => $params]);
    }

    public function createPage(Request $request) {
        $admin = Session::get('admin');
        $params = $request->all();
        return view('admin.company.create', ['adm' => $admin]);
    }

    public function create(Request $request) {
        $admin = Session::get('admin');
        $params = $request->all();
        $result = [
            'result' => true,
            'msg' => '新增成功',
        ];
        try {
            $companyRepository = new CompanyRepository();
            $companyRepository->create($params);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.account.createResult', ['adm' => $admin, 'result' => $result]);
    }

    public function edit(Request $request, $id) {
        $admin = Session::get('admin');
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $companyRepository = new CompanyRepository();
            $result['company'] = $companyRepository->getById($id);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin/company/edit', ['adm' => $admin, 'result' => $result]);
    }

    public function update(Request $request, $id) {
        $admin = Session::get('admin');
        $params = $request->all();
        $files = [];
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        /*
        if($request->hasFile('CustGIDPicture1'))
            $files['CustGIDPicture1'] = $request->file('CustGIDPicture1');
         */
        try {
            $companyRepository = new CompanyRepository();
            $companyRepository->updateById($id, $params, $admin, $files);
        } catch (Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.proccessResult', ['adm' => $admin, 'result' => $result]);
    }

    public function remove(Request $request, $id) {
        $admin = Session::get('admin');
        $files = [];
        $result = [
            'result' => true,
            'msg' => 'success',
        ];

        try {
            $companyRepository = new CompanyRepository();
            $companyRepository->del($id);
        } catch (Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.proccessResult', ['adm' => $admin, 'result' => $result]);
    }
}

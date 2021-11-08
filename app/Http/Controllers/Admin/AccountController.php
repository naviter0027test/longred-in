<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use \App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Session;
use Exception;

class AccountController extends Controller
{
    public function lists(Request $request) {
        $admin = Session::get('admin');
        $params = $request->all();
        $keyword = isset($params['keyword']) ? $params['keyword'] : '';
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset =  isset($params['offset']) ? $params['offset'] : 10;
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $userRepository = new UserRepository();
            $result['users'] = $userRepository->lists($params);
            $result['amount'] = $userRepository->listsAmount($params);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.user.index', ['adm' => $admin, 'result' => $result, 'offset' => $offset, 'nowPage' => $nowPage, 'keyword' => $keyword]);
    }

    public function createPage(Request $request) {
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        $admin = Session::get('admin');
        $params = $request->all();
        $params['offset'] = 9999;
        try {
            $userRepository = new UserRepository();
            $result['users'] = $userRepository->lists($params);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.user.create', ['adm' => $admin, 'result' => $result]);
    }

    public function create(Request $request) {
        $admin = Session::get('admin');
        $params = $request->all();
        $result = [
            'result' => true,
            'msg' => '新增成功',
        ];
        try {
            $userRepository = new UserRepository();
            $userRepository->create($params);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.proccessResult', ['adm' => $admin, 'result' => $result]);
    }

    public function edit(Request $request, $id) {
        $admin = Session::get('admin');
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $userRepository = new UserRepository();
            $result['user'] = $userRepository->getById($id);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.user.edit', ['adm' => $admin, 'result' => $result]);
    }

    public function update(Request $request, $id) {
        $admin = Session::get('admin');
        $params = $request->all();
        $result = [
            'result' => true,
            'msg' => '編輯成功',
        ];
        try {
            $userRepository = new UserRepository();
            $result['user'] = $userRepository->update($id, $params);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.user.createResult', ['adm' => $admin, 'result' => $result]);
    }

    public function remove(Request $request, $id) {
        $admin = Session::get('admin');
        $result = [
            'result' => true,
            'msg' => '刪除成功',
        ];
        try {
            $userRepository = new UserRepository();
            $userRepository->delById($id);
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return view('admin.user.createResult', ['adm' => $admin, 'result' => $result]);
    }
}

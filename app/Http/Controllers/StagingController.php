<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use App\Repositories\StagingRepository;
use Session;
use Exception;

class StagingController extends Controller
{
    public function indexPage(Request $request) {
        return view('user.staging.index');
    }

    public function index(Request $request) {
        $params = $request->all();
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? $params['offset'] : 10;
        $user = Session::get('user');
        $privileges = Session::get('seePrivileges');
        $params['userId'] = $user->id;
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        try {
            $stagingRepository = new StagingRepository();
            $result['stagings'] = $stagingRepository->lists($user, $params);
            $result['amount'] = $stagingRepository->listsAmount($user, $params);
            $result['nowPage'] = $nowPage;
            $result['offset'] = $offset;
        }
        catch(Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return json_encode($result);
    }

    public function uploadPage(Request $request) {
        return view('user.staging.upload');
    }

    public function upload(Request $request) {
        $params = $request->all();
        $files = [];
        $result = [
            'result' => true,
            'msg' => 'success',
        ];
        if($request->hasFile('img'))
            $files['img'] = $request->file('img');

        try {
            $stagingRepository = new StagingRepository();
            $stagingRepository->create($params, $files);
        } catch (Exception $e) {
            $result['result'] = false;
            $result['msg'] = $e->getMessage();
        }
        return json_encode($result);
    }
}

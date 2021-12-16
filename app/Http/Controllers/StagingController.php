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
    public function index(Request $request) {
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

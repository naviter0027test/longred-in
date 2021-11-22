<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Repositories\AndroidRepository;
use Session;
use Exception;

class UserController extends Controller
{
    public function loginPage(Request $request) {
        return view('user.login');
    }

    public function login(Request $request) {
        $result = [
            'status' => false,
            'msg' => 'login failure',
        ];
        $params = $request->all();
        $params['account'] = isset($params['account']) ? $params['account'] : '';
        $params['password'] = isset($params['password']) ? $params['password'] : '';
        /*
        $params['appleToken'] = isset($params['appleToken']) ? $params['appleToken'] : '';
        if(isset($params['tokenMode'])) {
            $tokenMode = (int) $params['tokenMode'];
            $params['tokenMode'] = $tokenMode == 0 ? 1 : $tokenMode;
        } else
            $params['tokenMode'] = 1;
         */
        $userRepository = new UserRepository();
        $user = $userRepository->checkPassword($params);
        if($user != false) {
            Session::put('user', $user);
            /*
            if(trim($params['appleToken']) != '') {
                $userRepository->appleTokenSet($user->id, $params['appleToken'], $params['tokenMode']);
            }
             */
            $result = [
                'status' => true,
                'msg' => 'login success',
            ];
            return json_encode($result);
        }
        return json_encode($result);
    }

    public function logout(Request $request) {
        Session::flush();
        $result = [
            'status' => true,
            'msg' => 'logout success',
        ];
        return json_encode($result);
    }

    public function isLogin(Request $request) {
        $result = [
            'status' => true,
            'msg' => 'has login'
        ];

        if(Session::has('user') == false) {
            $result = [
                'status' => false,
                'msg' => 'not login'
            ];
        }
        return json_encode($result);
    }
}

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
            if(trim($user->Privileges) != 'ALL') {
                $privilegesArr = explode(',', $user->Privileges);
                Session::put('seePrivileges', $privilegesArr);
            }
            else {
                $privileges = $userRepository->getPrivileges($user);
                $privilegesArr = [];
                foreach($privileges as $privilege) {
                    $privilegesArr[] = $privilege['UserId'];
                }
                Session::put('seePrivileges', $privilegesArr);
            }
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

    public function privileges(Request $request) {
        $result = [
            'status' => true,
            'msg' => 'success'
        ];
        $userRepository = new UserRepository();
        $user = Session::get('user');
        $result['privileges'] = $userRepository->getPrivileges($user);
        return json_encode($result);
    }

    public function privilegesSetSeePage(Request $request) {
        return view('user.setsee');
    }

    public function privilegesSetSee(Request $request) {
        $result = [
            'status' => true,
            'msg' => 'success'
        ];
        try {
            $params = $request->all();
            $user = Session::get('user');
            if(trim($user->Privileges) != 'ALL') {
                $userPrivileges = explode(',', $user->Privileges);
                foreach($params['privileges'] as $privilege) {
                    if(is_null($privilege) == true)
                        continue;
                    if(in_array($privilege, $userPrivileges) == false) {
                        throw new Exception("this [$privilege] is not in user privileges 該權限非屬於此業務員的");
                    }
                }
            }
            foreach($params['privileges'] as $i => $privilege) {
                if(is_null($privilege) == true)
                    unset($params['privileges'][$i]);
            }
            Session::put('seePrivileges', $params['privileges']);
        } catch (Exception $e) {
            $result['status'] = false;
            $result['msg'] = $e->getMessage();
        }
        return json_encode($result);
    }

    public function privilegesGetSee(Request $request) {
        $result = [
            'status' => true,
            'msg' => 'success'
        ];
        $result['privileges'] = Session::get('seePrivileges');
        return json_encode($result);
    }
}

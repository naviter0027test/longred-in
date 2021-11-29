<?php

namespace App\Repositories;

use App\User;
use Exception;
use Config;

class UserRepository
{
    public function lists($params) {
        $keyword = isset($params['keyword']) ? $params['keyword'] : '';
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? $params['offset'] : 10;
        $users = User::where(function ($query) use ($keyword) {
                $query->orWhere('UserName', 'like', "%$keyword%");
                //$query->orWhere('Area', 'like', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->skip(($nowPage-1) * $offset)
            ->take($offset)
            ->get();
        if(isset($users[0])) {
            return $users;
        }
        return [];
    }

    public function listsAmount($params) {
        $keyword = isset($params['keyword']) ? $params['keyword'] : '';
        $amount = User::where('UserName', 'like', "%$keyword%")
            ->count();
        return $amount;
    }

    public function create($params) {
        $userTmp = isset($params['UserId']) ? $params['UserId'] : '';
        $checkUser = User::where('UserId', '=', $userTmp)
            ->first();
        if(isset($checkUser->id))
            throw new Exception('帳號重複');
        if(isset($params['isPrivilegesAll']) && $params['isPrivilegesAll'] == 'ALL')
            $params['Privileges'] = ['ALL'];
        else if(isset($params['Privileges']) && is_array($params['Privileges']))
            $params['Privileges'][] = $userTmp;
        else if(isset($params['Privileges']) && is_string($params['Privileges'])) {
            $privilege = $params['Privileges'];
            $params['Privileges'] = [$userTmp, $privilege];
        }
        $user = new User();
        $user->UserId = $userTmp;
        $user->Password = isset($params['Password']) ? $params['Password'] : '';
        $user->UserName = isset($params['UserName']) ? $params['UserName'] : '';
        $user->Area = isset($params['Area']) ? $params['Area'] : '';
        $user->Privileges = isset($params['Privileges']) ? implode(',', $params['Privileges']) : '';
        $user->save();
    }

    public function getById($id) {
        $user = User::where('id', '=', $id)
            ->first();
        if(isset($user->id) == false)
            throw new Exception('帳號不存在');
        $user->privileges = explode(',', $user->Privileges);
        $user->isPrivilegesAll = false;
        if(in_array('ALL', $user->privileges))
            $user->isPrivilegesAll = true;
        return $user;
    }

    public function update($id, $params) {
        $userTmp = isset($params['UserId']) ? $params['UserId'] : '';
        $user = User::where('id', '=', $id)
            ->first();
        if(isset($params['isPrivilegesAll']) && $params['isPrivilegesAll'] == 'ALL')
            $params['Privileges'] = ['ALL'];
        else if(isset($params['Privileges']) && is_array($params['Privileges']) && in_array($userTmp, $params['Privileges']) == false)
            $params['Privileges'][] = $userTmp;

        $user->UserId = $userTmp;
        if(isset($params['Password']) && trim($params['Password']) != '')
            $user->Password = $params['Password'];
        $user->UserName = isset($params['UserName']) ? $params['UserName'] : '';
        $user->Area = isset($params['Area']) ? $params['Area'] : '';
        $user->Privileges = isset($params['Privileges']) ? implode(',', $params['Privileges']) : '';
        $user->save();
    }

    public function delById($id) {
        $user = User::where('id', '=', $id)
            ->first();
        if(isset($user->id) == false)
            throw new Exception('帳號不存在');
        $user->delete();
    }

    public function checkPassword($params) {
        $user = User::where('UserId', '=', $params['account'])
            ->where('Password', '=', $params['password'])
            ->first();
        if(isset($user->id)) {
            return $user;
        }
        return false;
    }
}

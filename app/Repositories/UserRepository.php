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
        $users = User::where('UserName', 'like', "%$keyword%")
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
        $user = new User();
        $user->UserId = $userTmp;
        $user->Password = isset($params['Password']) ? $params['Password'] : '';
        $user->UserName = isset($params['UserName']) ? $params['UserName'] : '';
        $user->Area = isset($params['Area']) ? $params['Area'] : '';
        $user->Privileges = isset($params['Privileges']) ? implode(',', $params['Privileges']) : '';
        $user->save();
    }
}

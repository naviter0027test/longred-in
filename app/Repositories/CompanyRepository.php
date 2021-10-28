<?php

namespace App\Repositories;

use App\Company;
use Exception;
use Config;

class CompanyRepository
{
    public function lists($params) {
        $keyword = isset($params['keyword']) ? $params['keyword'] : '';
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? $params['offset'] : 10;
        $companies = Company::where('UserName', 'like', "%$keyword%")
            ->orderBy('id', 'desc')
            ->skip(($nowPage-1) * $offset)
            ->take($offset)
            ->get();
        if(isset($companies[0])) {
            return $companies;
        }
        return [];
    }

    public function listsAmount($params) {
        $keyword = isset($params['keyword']) ? $params['keyword'] : '';
        $amount = Company::where('UserName', 'like', "%$keyword%")
            ->count();
        return $amount;
    }

    public function create($params) {
        $companyTmp = isset($params['UserId']) ? $params['UserId'] : '';
        $checkCompany = Company::where('UserId', '=', $companyTmp)
            ->first();
        if(isset($checkCompany->id))
            throw new Exception('帳號重複');
        $company = new Company();
        $company->UserId = $companyTmp;
        $company->Password = isset($params['Password']) ? $params['Password'] : '';
        $company->UserName = isset($params['UserName']) ? $params['UserName'] : '';
        $company->created_at = date('Y-m-d H:i:s');
        $company->updated_at = date('Y-m-d H:i:s');
        $company->save();
    }
}

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
        $company->Address = isset($params['Address']) ? $params['Address'] : '';
        $company->Tel = isset($params['Tel']) ? $params['Tel'] : '';
        $company->created_at = date('Y-m-d H:i:s');
        $company->updated_at = date('Y-m-d H:i:s');
        $company->save();
    }

    public function getById($id) {
        $company = Company::where('id', '=', $id)
            ->first();
        if(isset($company->id) == false) {
            throw new Exception('廠商不存在');
        }
        return $company;
    }

    public function updateById($id, $params, $admin, $files = []) {
        $company = Company::where('id', '=', $id)
            ->first();
        if(isset($company->id) == false) {
            throw new Exception('案件不存在');
        }
        $company->Password = isset($params['Password']) ? $params['Password'] : '';
        $company->UserName = isset($params['UserName']) ? $params['UserName'] : '';
        $company->Address = isset($params['Address']) ? $params['Address'] : '';
        $company->Tel = isset($params['Tel']) ? $params['Tel'] : '';
        $company->updated_at = date('Y-m-d H:i:s');

        $company->save();

        $root = config('filesystems')['disks']['uploads']['root'];
        $path = date('/Y/m'). '/';
        /*
        if(isset($files['CustGIDPicture1'])) {
            if(trim($record->CustGIDPicture1) == '') {
                $ext = $files['CustGIDPicture1']->getClientOriginalExtension();
                $filename = $record->id. "_pic1.$ext";
                $record->CustGIDPicture1 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->CustGIDPicture1);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['CustGIDPicture1']->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
         */
    }

    public function del($id) {
        $company = Company::where('id', '=', $id)
            ->first();
        if(isset($company->id) == false) {
            throw new Exception('廠商不存在');
        }
        $company->delete();
    }

    public function listsByApi($user, $params) {
        $keyword = isset($params['keyword']) ? $params['keyword'] : '';
        $nowPage = isset($params['nowPage']) ? $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? $params['offset'] : 10;
        $companies = Company::where('UserName', 'like', "%$keyword%")
            ->orderBy('id', 'desc')
            ->skip(($nowPage-1) * $offset)
            ->take($offset)
            ->get();
        foreach($companies as $i => $company) {
            $companyAttr = $company->getAttributes();
            foreach($companyAttr as $key => $value) {
                if(is_null($value)) {
                    $companies[$i]->{$key} = '';
                }
            }
        }
        if(isset($companies[0])) {
            return $companies;
        }
        return [];
    }

    public function listsByApiAmount($user, $params) {
        $keyword = isset($params['keyword']) ? $params['keyword'] : '';
        $amount = Company::where('UserName', 'like', "%$keyword%")
            ->count();
        return $amount;
    }
}

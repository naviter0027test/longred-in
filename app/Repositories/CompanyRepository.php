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

    public function importRow($row, $admin) {
        if(isset($row[0]) == false) {
            throw new \Exception('第一欄 必填');
        }
        $record = Company::where('UserId', '=', $row[0])
            ->first();

        //已存在的情況下，視為編輯。相反則是為新增
	/*
        if(isset($record->CustID)) {
            //$record->CustID = (isset($row[0]) ? $row[0] : '');
            $record->CaseID = (isset($row[1]) ? $row[1] : '');
            $record->CustName = (isset($row[2]) ? $row[2] : '');
            $record->CustProjectStatus = (isset($row[3]) ? $row[3] : '');
            $record->SubId = (isset($row[4]) ? $row[4] : '');
            $record->SubIdSource = (isset($row[5]) ? $row[5] : '');
            $record->SubIdAcceptPayment = (isset($row[6]) ? $row[6] : '');
            if(isset($row[7]) && trim($row[7]) != '') {
                $CustAllowDenyTime = date('Y-m-d H:i:s', strtotime($row[7]));
                $record->CustAllowDenyTime = $CustAllowDenyTime;
            }
            $record->CarModelType = (isset($row[8]) ? $row[8] : '');
            $record->CustLoanCash = (isset($row[9]) ? $row[9] : 0);
            $record->CustFinalDeposit = (isset($row[10]) ? $row[10] : 0);
            $record->Term = (isset($row[11]) ? $row[11] : 0);
            $record->TermAmount = (isset($row[12]) ? $row[12] : 0);
            $record->AllowDenyDesc = (isset($row[13]) ? $row[13] : '');
            $record->CustPayStatus = (isset($row[14]) ? $row[14] : '');
            if(isset($row[15]) && trim($row[15]) != '') {
                $MoneyCloseDate = date('Y-m-d H:i:s', strtotime($row[15]));
                $record->MoneyCloseDate = $MoneyCloseDate;
            }
            $record->ActualPayCarRetailer = (isset($row[16]) ? $row[16] : '');
            $record->SubIdName = (isset($row[17]) ? $row[17] : '');
            $record->SubIdSourceName = (isset($row[18]) ? $row[18] : '');
            $record->SubIdAcceptPaymentName = (isset($row[19]) ? $row[19] : '');
            $record->Plate = (isset($row[20]) ? $row[20] : '');
            $record->CustProjectCategory = (isset($row[21]) ? $row[21] : '');
            $record->SubArea = (isset($row[22]) ? $row[22] : '');
            if(isset($row[23]) && trim($row[23]) != '') {
                $CustCreateTime = date('Y-m-d H:i:s', strtotime($row[23]));
                $record->CustCreateTime = $CustCreateTime;
            }
            $record->CarModelName = (isset($row[24]) ? $row[24] : '');
            $record->CustGID = (isset($row[25]) ? $row[25] : '');
            $record->AppID = (isset($row[26]) ? $row[26] : '');
            $record->DocumentMemo = (isset($row[27]) ? $row[27] : '');
            $record->CustFinalProjectID = (isset($row[28]) ? $row[28] : '');
            $record->CustFee = (isset($row[29]) ? $row[29] : 0);
            $record->CustWaitCheckItem = (isset($row[30]) ? $row[30] : '');
            if(isset($row[31]) && trim($row[31]) != '') {
                $ApplicationReceivedDate = date('Y-m-d H:i:s', strtotime($row[31]));
                $record->ApplicationReceivedDate = $ApplicationReceivedDate;
            }
            if(isset($row[32]) && trim($row[32]) != '') {
                $LicenseReceivedDate = date('Y-m-d H:i:s', strtotime($row[32]));
                $record->LicenseReceivedDate = $LicenseReceivedDate;
            }
            if(isset($row[33]) && trim($row[33]) != '') {
                $RenewalLicenseDate = date('Y-m-d H:i:s', strtotime($row[33]));
                $record->RenewalLicenseDate = $RenewalLicenseDate;
            }
            $record->ForSalesMemo = (isset($row[34]) ? $row[34] : '');
            $record->VehicleLoanFeeIn = (isset($row[35]) ? intval(preg_replace('/,/', '', $row[35])) : 0);
            $record->Insurance = (isset($row[36]) ? $row[36] : '');
            $record->SalesID = (isset($row[37]) ? intval($row[37]) : 0);
            $record->SalesName = (isset($row[38]) ? $row[38] : '');
            if(isset($row[39]) && trim($row[39]) != '') {
                $FirstPayDate = date('Y-m-d H:i:s', strtotime($row[39]));
                $record->FirstPayDate =  $FirstPayDate;
            }
            $record->CustBillAddress = (isset($row[40]) ? $row[40] : '');
            if(isset($row[41]) && trim($row[41]) != '') {
                $BillSendDate = date('Y-m-d H:i:s', strtotime($row[41]));
                $record->BillSendDate = $BillSendDate;
            }
            $record->ATMAccount = (isset($row[42]) ? $row[42] : '');
            $record->CaseCategoryType = (isset($row[43]) ? $row[43] : '');
            $record->ApplicationType = (isset($row[44]) ? $row[44] : '');
        } else {
	 */
            $record = new Company();
            $record->UserId = (isset($row[0]) ? $row[0] : '');
            $record->UserName = (isset($row[1]) ? $row[1] : '');
            $record->Password = (isset($row[2]) ? $row[2] : '');
            $record->Tel = (isset($row[3]) ? $row[3] : '');
            $record->Address = (isset($row[4]) ? $row[4] : '');
            $record->created_at = date('Y-m-d H:i:s');
            $record->updated_at = date('Y-m-d H:i:s');
        //}
        $record->save();
    }
}

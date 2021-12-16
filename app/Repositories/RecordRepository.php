<?php

namespace App\Repositories;

use App\Record;
use App\Account;
use Exception;
use Storage;

class RecordRepository
{
    public function create($params, $files = []) {
        $today = date('Y-m-d');
        $recordCount = Record::where('created_at', '>=' , "$today 00:00:00")
            ->where('created_at', '<=', "$today 23:59:59")
            ->count();
        $submitId = date('ymd'). 'A'. str_pad($recordCount+1, 3, '0', STR_PAD_LEFT). rand(10, 99);
        $record = new Record();
        $record->submitId = $submitId;
        $record->CustGID = isset($params['CustGID']) ? $params['CustGID'] : '';
        $record->applicant = isset($params['applicant']) ? $params['applicant'] : '';
        $record->checkStatus = '處理中';
        $record->inCharge = '';
        $record->productName = isset($params['productName']) ? $params['productName'] : '';
        $record->applyAmount = isset($params['applyAmount']) ? $params['applyAmount'] : 0;
        $record->loanAmount = 0;
        $record->periods = 0;
        $record->periodAmount = 0;
        $record->content = '';
        $record->schedule = '';
        $record->grantAmount = 0;
        $record->liense = isset($params['liense']) ? $params['liense'] : '';
        $record->ProjectCategory = '';
        $record->memo = isset($params['memo']) ? $params['memo'] : '';
        $record->created_at = date('Y-m-d H:i:s');
        $record->updated_at = date('Y-m-d H:i:s');
        if(isset($params['accountId']))
            $record->accountId = $params['accountId'];
        $record->save();

        $root = config('filesystems')['disks']['uploads']['root'];
        $path = date('/Y/m'). '/';
        if(isset($files['CustGIDPicture1'])) {
            $ext = $files['CustGIDPicture1']->getClientOriginalExtension();
            $filename = $record->id. "_pic1.$ext";
            $record->CustGIDPicture1 = $path. $filename;
            $record->save();
            $files['CustGIDPicture1']->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['CustGIDPicture2'])) {
            $ext = $files['CustGIDPicture2']->getClientOriginalExtension();
            $filename = $record->id. "_pic2.$ext";
            $record->CustGIDPicture2 = $path. $filename;
            $record->save();
            $files['CustGIDPicture2']->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['applyUploadPath'])) {
            $ext = $files['applyUploadPath']->getClientOriginalExtension();
            $filename = $record->id. "_apply.$ext";
            $record->applyUploadPath = $path. $filename;
            $record->save();
            $files['applyUploadPath']->move($root. $path, $filename);
        }
        if(isset($files['proofOfProperty'])) {
            $ext = $files['proofOfProperty']->getClientOriginalExtension();
            $filename = $record->id. "_property.$ext";
            $record->proofOfProperty = $path. $filename;
            $record->save();
            $files['proofOfProperty']->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][0])) {
            $ext = $files['otherDoc'][0]->getClientOriginalExtension();
            $filename = $record->id. "_other.$ext";
            $record->otherDoc = $path. $filename;
            $record->save();
            $files['otherDoc'][0]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][1])) {
            $ext = $files['otherDoc'][1]->getClientOriginalExtension();
            $filename = $record->id. "_other2.$ext";
            $record->otherDoc2 = $path. $filename;
            $record->save();
            $files['otherDoc'][1]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][2])) {
            $ext = $files['otherDoc'][2]->getClientOriginalExtension();
            $filename = $record->id. "_other3.$ext";
            $record->otherDoc3 = $path. $filename;
            $record->save();
            $files['otherDoc'][2]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][3])) {
            $ext = $files['otherDoc'][3]->getClientOriginalExtension();
            $filename = $record->id. "_other4.$ext";
            $record->otherDoc4 = $path. $filename;
            $record->save();
            $files['otherDoc'][3]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][4])) {
            $ext = $files['otherDoc'][4]->getClientOriginalExtension();
            $filename = $record->id. "_other5.$ext";
            $record->otherDoc5 = $path. $filename;
            $record->save();
            $files['otherDoc'][4]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][5])) {
            $ext = $files['otherDoc'][5]->getClientOriginalExtension();
            $filename = $record->id. "_other6.$ext";
            $record->otherDoc6 = $path. $filename;
            $record->save();
            $files['otherDoc'][5]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }

        $params['recordId'] = $record->id;
        $messageRepository = new MessageRepository();
        $messageRepository->recordAdd($params);
    }

    public function lists($params) {
        $nowPage = isset($params['nowPage']) ? (int) $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? (int) $params['offset'] : 100;
        $startDate = date('Y-m-d 00:00:00', strtotime('-3 months'));

        $recordQuery = Record::orderBy('CustCreateTime', 'desc')
            ->skip(($nowPage-1) * $offset)
            ->take($offset);
        /*
        if(isset($params['dealer']) && trim($params['dealer']) != '') {
            $recordQuery->where('dealer', 'like', "%". $params['dealer']. "%");
        }
        if(isset($params['schedule']) && trim($params['schedule']) != '') {
            $recordQuery->where('schedule', '=', $params['schedule']);
        }
        if(isset($params['startDate'])) {
            $startDate = $params['startDate']. ' 00:00:00';
        }
        $recordQuery->where('created_at', '>=', $startDate);
        if(isset($params['endDate'])) {
            $endDate = $params['endDate']. ' 23:59:59';
            $recordQuery->where('created_at', '<=', $endDate);
        }
        if(isset($params['accountId'])) {
            $account = Account::where('id', '=', $params['accountId'])
                ->first();
            $recordQuery->where(function($query) use($params, $account) {
                $query->orWhere('accountId', '=', $params['accountId']);
                $query->orWhere('dealer', '=', $account->account);
            });
        }
         */
        if(isset($params['CustProjectStatus']) && trim($params['CustProjectStatus']) != '') {
            $recordQuery->where('CustProjectStatus', '=', $params['CustProjectStatus']);
        }
        if(isset($params['keyword'])) {
            $recordQuery->where(function($query) use ($params) {
                $query->orWhere('CustName', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('SubIdName', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('SubArea', 'like', '%'. $params['keyword']. '%');
            });
        }
        $records = $recordQuery->get();
        /*
        foreach($records as $record) {
            if(is_null($record->allowDate) == false) {
                $record->allowDate = date('Y-m-d', strtotime($record->allowDate));
            }
            if(is_null($record->grantDate) == false) {
                $record->grantDate = date('Y-m-d', strtotime($record->grantDate));
            }
	    $record->applyAmount .= '';
	    $record->loanAmount .= '';
	    $record->periods .= '';
	    $record->periodAmount .= '';
	    $record->accountId .= '';
        }
         */
        return $records;
    }

    public function listsAmount($params) {
        $recordQuery = Record::orderBy('CustCreateTime', 'desc');
        $startDate = date('Y-m-d 00:00:00', strtotime('-3 months'));
        /*
        if(isset($params['dealer']) && trim($params['dealer']) != '') {
            $recordQuery->where('dealer', 'like', "%". $params['dealer']. "%");
        }
        if(isset($params['schedule']) && trim($params['schedule']) != '') {
            $recordQuery->where('schedule', '=', $params['schedule']);
        }
        if(isset($params['startDate'])) {
            $startDate = $params['startDate']. ' 00:00:00';
        }
        $recordQuery->where('created_at', '>=', $startDate);
        if(isset($params['endDate'])) {
            $endDate = $params['endDate']. ' 23:59:59';
            $recordQuery->where('created_at', '<=', $endDate);
        }
        if(isset($params['accountId'])) {
            $account = Account::where('id', '=', $params['accountId'])
                ->first();
            $recordQuery->where(function($query) use($params, $account) {
                $query->orWhere('accountId', '=', $params['accountId']);
                $query->orWhere('dealer', '=', $account->account);
            });
        }
         */
        if(isset($params['CustProjectStatus']) && trim($params['CustProjectStatus']) != '') {
            $recordQuery->where('CustProjectStatus', '=', $params['CustProjectStatus']);
        }
        if(isset($params['keyword'])) {
            $recordQuery->where(function($query) use ($params) {
                $query->orWhere('CustName', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('SubIdName', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('SubArea', 'like', '%'. $params['keyword']. '%');
            });
        }
        return $recordQuery->count();
    }

    public function import($file, $admin) {
        $content = \File::get($file->getRealPath());
        $arr = preg_split("/\n/", $content);
        $resultRow = [];
        foreach($arr as $i => $row) {
            try {
                $csv = str_getcsv($row, ",");
                $this->importRow($csv, $admin);
                $resultRow[$i] = [
                    'status' => true,
                    'msg' => 'success',
                ];
            } catch (\Exception $e) {
                $resultRow[$i] = [
                    'status' => false,
                    'msg' => $e->getMessage(),
                ];
            }
        }
        return $resultRow;
    }

    public function importRow($row, $admin) {
        if(isset($row[0]) == false) {
            throw new \Exception('CustID 必填');
        }
        $record = Record::where('CustID', '=', $row[0])
            ->first();

        //已存在的情況下，視為編輯。相反則是為新增
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
            $record->VehicleLoanFeeIn = (isset($row[35]) ? intval($row[35]) : 0);
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
            $record = new Record();
            $record->CustID = (isset($row[0]) ? $row[0] : '');
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
            $record->VehicleLoanFeeIn = (isset($row[35]) ? intval($row[35]) : 0);
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
        }
        $record->save();
    }

        /*
    public function importRow($row, $admin) {
        if(isset($row[0]) == false) {
            throw new \Exception('submitId 必填');
        }
        $record = Record::where('submitId', '=', $row[0])
            ->first();
        $allowDate = null;
        $grantDate = null;
        $createDate = date('Y-m-d H:i:s');
        if(isset($row[7]))
            $allowDate = date('Y-m-d H:i:s', strtotime($row[7]));
        if(isset($row[15]) && trim($row[15]) != '')
            $grantDate = date('Y-m-d H:i:s', strtotime($row[15]));
        if(isset($row[23]) && trim($row[23]) != '')
            $createDate = date('Y-m-d H:i:s', strtotime($row[23]));
        //已存在的情況下，視為編輯。相反則是為新增
        if(isset($record->id)) {
            $record->contractId = isset($row[1]) ? $row[1] : '';
            $record->applicant = isset($row[2]) ? $row[2] : '';
            $record->dealer = isset($row[4]) ? $row[4] : '';
            $record->inCharge = isset($row[5]) ? $row[5] : '';
            $record->beneficiary = isset($row[6]) ? $row[6] : '';
            $record->allowDate = $allowDate;
            $record->product = isset($row[8]) ? $row[8] : '';
            $record->applyAmount = isset($row[9]) ? $row[9] : 0;
            $record->loanAmount = isset($row[10]) ? $row[10] : 0;
            $record->periods = isset($row[11]) ? $row[11] : 0;
            $record->periodAmount = isset($row[12]) ? $row[12] : 0;
            $record->content = isset($row[13]) ? $row[13] : '';
            $record->grantDate = $grantDate;
            $record->grantAmount = isset($row[16]) ? $row[16] : 0;
            $record->dealerName = isset($row[17]) ? $row[17] : '';
            $record->inChargeName = isset($row[18]) ? $row[18] : '';
            $record->beneficiaryName = isset($row[19]) ? $row[19] : '';
            $record->liense = isset($row[20]) ? $row[20] : '';
            $record->ProjectCategory = isset($row[21]) ? $row[21] : '';
            $record->SubArea = isset($row[22]) ? $row[22] : '';
            $record->productName = isset($row[24]) ? $row[24] : '';
            $record->CustGID = isset($row[25]) ? $row[25] : '';
            $record->updated_at = date('Y-m-d H:i:s');

            $checkArr = [
                '處理中',
                '待核准',
                '核准',
                '取消申辦',
                '婉拒',
            ];
            if(isset($row[3]) && in_array($row[3], $checkArr) == true) {
                if($record->checkStatus != $row[3]) {
                    $oldStatus = $record->checkStatus;
                    $newStatus = $row[3];
                    $messageRepository = new MessageRepository();
                    try {
                        $messageRepository->statusUpdate($record->id, "審核狀況：$oldStatus -> $newStatus (". $record->applicant. ")", $admin->id, '[案件狀態變更]');
                    } catch (Exception $e) {
                        \Log::info('record id: '. $record->id. ' log:'. $e->getMessage());
                    }
                }
                $record->checkStatus = $row[3];
            }
            $scheduleArr = [
                '核准',
                '已撥款',
            ];
            if(isset($row[14]) && in_array($row[14], $scheduleArr) == true) {
                if($record->schedule != $row[14]) {
                    $oldStatus = $record->schedule;
                    $newStatus = $row[14];
                    $messageRepository = new MessageRepository();
                    try {
                        $messageRepository->statusUpdate($record->id, "撥款狀況：$oldStatus -> $newStatus (". $record->applicant. ")", $admin->id, '[撥款狀態變更]');
                    } catch (Exception $e) {
                        \Log::info('record id: '. $record->id. ' log:'. $e->getMessage());
                    }
                }
                $record->schedule = $row[14];
            }
        } else {
            $record = new Record;
            $record->submitId = isset($row[0]) ? $row[0] : '';
            $record->contractId = isset($row[1]) ? $row[1] : '';
            $record->applicant = isset($row[2]) ? $row[2] : '';
            $record->checkStatus = isset($row[3]) ? $row[3] : '處理中';
            $record->dealer = isset($row[4]) ? $row[4] : '';
            $record->inCharge = isset($row[5]) ? $row[5] : '';
            $record->beneficiary = isset($row[6]) ? $row[6] : '';
            $record->allowDate = $allowDate;
            $record->product = isset($row[8]) ? $row[8] : '';
            $record->applyAmount = isset($row[9]) ? $row[9] : 0;
            $record->loanAmount = isset($row[10]) ? $row[10] : 0;
            $record->periods = isset($row[11]) ? $row[11] : 0;
            $record->periodAmount = isset($row[12]) ? $row[12] : 0;
            $record->content = isset($row[13]) ? $row[13] : '';
            $record->schedule = isset($row[14]) ? $row[14] : '';
            $record->grantDate = $grantDate;
            $record->grantAmount = isset($row[16]) ? $row[16] : 0;
            $record->dealerName = isset($row[17]) ? $row[17] : '';
            $record->inChargeName = isset($row[18]) ? $row[18] : '';
            $record->beneficiaryName = isset($row[19]) ? $row[19] : '';
            $record->liense = isset($row[20]) ? $row[20] : '';
            $record->ProjectCategory = isset($row[21]) ? $row[21] : '';
            $record->SubArea = isset($row[22]) ? $row[22] : '';
            $record->productName = isset($row[24]) ? $row[24] : '';
            $record->CustGID = isset($row[25]) ? $row[25] : '';
            $record->created_at = $createDate;
            $record->updated_at = date('Y-m-d H:i:s');
        }
        $record->save();
    }
         */

    public function getById($id) {
        $record = Record::where('CustID', '=', $id)
            ->first();
        if(isset($record->CustID) == false) {
            throw new Exception('案件不存在');
        }
        if(is_null($record->CustAllowDenyTime) == false)
            $record->CustAllowDenyTime = date('Y-m-d', strtotime($record->CustAllowDenyTime));
        if(is_null($record->MoneyCloseDate) == false)
            $record->MoneyCloseDateVal = date('Y-m-d', strtotime($record->MoneyCloseDate));
        if(is_null($record->CustCreateTime) == false)
            $record->CustCreateTimeVal = date('Y-m-d', strtotime($record->CustCreateTime));
        if(is_null($record->ApplicationReceivedDate) == false)
            $record->ApplicationReceivedDateVal = date('Y-m-d', strtotime($record->ApplicationReceivedDate));
        if(is_null($record->LicenseReceivedDate) == false)
            $record->LicenseReceivedDateVal = date('Y-m-d', strtotime($record->LicenseReceivedDate));
        if(is_null($record->RenewalLicenseDate) == false)
            $record->RenewalLicenseDateVal = date('Y-m-d', strtotime($record->RenewalLicenseDate));
        if(is_null($record->FirstPayDate) == false)
            $record->FirstPayDateVal = date('Y-m-d', strtotime($record->FirstPayDate));
        if(is_null($record->BillSendDate) == false)
            $record->BillSendDateVal = date('Y-m-d', strtotime($record->BillSendDate));
        return $record;
    }

    public function updateById($id, $params, $admin, $files = []) {
        $record = Record::where('id', '=', $id)
            ->first();
        if(isset($record->id) == false) {
            throw new Exception('案件不存在');
        }
        $record->CustGID = isset($params['CustGID']) ? $params['CustGID'] : '';
        $record->applicant = isset($params['applicant']) ? $params['applicant'] : '';
        $record->dealer = isset($params['dealer']) ? $params['dealer'] : '';
        $record->dealerName = isset($params['dealerName']) ? $params['dealerName'] : '';
        $record->inCharge = isset($params['inCharge']) ? $params['inCharge'] : '';
        $record->inChargeName = isset($params['inChargeName']) ? $params['inChargeName'] : '';
        $record->beneficiary = isset($params['beneficiary']) ? $params['beneficiary'] : '';
        $record->beneficiaryName = isset($params['beneficiaryName']) ? $params['beneficiaryName'] : '';
        if(isset($params['allowDate']) && is_null($params['allowDate']) == false)
            $record->allowDate = $params['allowDate']. ' 00:00:00';
        $record->productName = isset($params['productName']) ? $params['productName'] : '';
        $record->applyAmount = isset($params['applyAmount']) ? $params['applyAmount'] : 0;
        $record->loanAmount = isset($params['loanAmount']) ? $params['loanAmount'] : 0;
        $record->periods = isset($params['periods']) ? $params['periods'] : 0;
        $record->periodAmount = isset($params['periodAmount']) ? $params['periodAmount'] : 0;
        $record->content = isset($params['content']) ? $params['content'] : '';
        if(isset($params['grantDate']) && is_null($params['grantDate']) == false)
            $record->grantDate = $params['grantDate']. ' 00:00:00';
        $record->grantAmount = isset($params['grantAmount']) ? $params['grantAmount'] : 0;
        $record->liense = isset($params['liense']) ? $params['liense'] : '';
        $record->SubArea = isset($params['SubArea']) ? $params['SubArea'] : '';
        $record->ProjectCategory = isset($params['ProjectCategory']) ? $params['ProjectCategory'] : '';
        $record->memo = isset($params['memo']) ? $params['memo'] : '';
        $record->updated_at = date('Y-m-d H:i:s');


        if(isset($params['checkStatus']) && is_null($params['checkStatus']) == false) {
            if($record->checkStatus != $params['checkStatus']) {
                $oldStatus = $record->checkStatus;
                $newStatus = $params['checkStatus'];
                $messageRepository = new MessageRepository();
                $messageRepository->statusUpdate($record->id, "審核狀況：$oldStatus -> $newStatus (". $record->applicant. ")", $admin->id, '[案件狀態變更]');
            }
            $record->checkStatus =  $params['checkStatus'];
        }
        if(isset($params['schedule']) && is_null($params['schedule']) == false) {
            if($record->schedule != $params['schedule']) {
                $oldStatus = $record->schedule;
                $newStatus = $params['schedule'];
                $messageRepository = new MessageRepository();
                $messageRepository->statusUpdate($record->id, "撥款狀況：$oldStatus -> $newStatus (". $record->applicant. ")", $admin->id, '[撥款狀態變更]');
            }
            $record->schedule = $params['schedule'];
        }

        $record->save();

        $root = config('filesystems')['disks']['uploads']['root'];
        $path = date('/Y/m'). '/';
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
        if(isset($files['CustGIDPicture2'])) {
            if(trim($record->CustGIDPicture2) == '') {
                $ext = $files['CustGIDPicture2']->getClientOriginalExtension();
                $filename = $record->id. "_pic2.$ext";
                $record->CustGIDPicture2 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->CustGIDPicture2);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['CustGIDPicture2']->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['applyUploadPath'])) {
            if(trim($record->applyUploadPath) == '') {
                $ext = $files['applyUploadPath']->getClientOriginalExtension();
                $filename = $record->id. "_apply.$ext";
                $record->applyUploadPath = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->applyUploadPath);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['applyUploadPath']->move($root. $path, $filename);
        }
        if(isset($files['proofOfProperty'])) {
            if(trim($record->proofOfProperty) == '') {
                $ext = $files['proofOfProperty']->getClientOriginalExtension();
                $filename = $record->id. "_property.$ext";
                $record->proofOfProperty = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->proofOfProperty);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['proofOfProperty']->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][0])) {
            if(trim($record->otherDoc) == '') {
                $ext = $files['otherDoc'][0]->getClientOriginalExtension();
                $filename = $record->id. "_other.$ext";
                $record->otherDoc = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][0]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][1])) {
            if(trim($record->otherDoc2) == '') {
                $ext = $files['otherDoc'][1]->getClientOriginalExtension();
                $filename = $record->id. "_other2.$ext";
                $record->otherDoc2 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc2);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][1]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][2])) {
            if(trim($record->otherDoc3) == '') {
                $ext = $files['otherDoc'][2]->getClientOriginalExtension();
                $filename = $record->id. "_other3.$ext";
                $record->otherDoc3 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc3);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][2]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][3])) {
            if(trim($record->otherDoc4) == '') {
                $ext = $files['otherDoc'][3]->getClientOriginalExtension();
                $filename = $record->id. "_other4.$ext";
                $record->otherDoc4 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc4);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][3]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][4])) {
            if(trim($record->otherDoc5) == '') {
                $ext = $files['otherDoc'][4]->getClientOriginalExtension();
                $filename = $record->id. "_other5.$ext";
                $record->otherDoc5 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc5);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][4]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][5])) {
            if(trim($record->otherDoc6) == '') {
                $ext = $files['otherDoc'][5]->getClientOriginalExtension();
                $filename = $record->id. "_other6.$ext";
                $record->otherDoc6 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc6);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][5]->move($root. $path, $filename);

            $this->addText($root. $path. $filename);
        }
    }

    public function del($id) {
        $record = Record::where('id', '=', $id)
            ->first();
        if(isset($record->id) == false) {
            throw new Exception('案件不存在');
        }
        $record->delete();
    }

    public function cancel($id, $accountId) {
        $account = Account::where('id', '=', $accountId)
            ->first();
        $record = Record::where('id', '=', $id)
            ->where(function($query) use ($account) {
                $query->orWhere('accountId', '=', $account->id);
                $query->orWhere('dealer', '=', $account->account);
            })
            ->first();
        if(isset($record->id) == false) {
            throw new Exception('案件不存在');
        }
        if($record->checkStatus != '處理中') {
            throw new Exception('審核狀態須為處理中才可取消');
        }
        $record->checkStatus = '取消申辦';
        $record->save();

        $messageRepository = new MessageRepository();
        $messageRepository->cancelNotify($record);
    }

    public function updateFileById($id, $files = []) {
        $record = Record::where('id', '=', $id)
            ->first();
        if(isset($record->id) == false) {
            throw new Exception('案件不存在');
        }

        $notify = [
            'CustGIDPicture1' => false,
            'CustGIDPicture2' => false,
            'applyUploadPath' => false,
            'proofOfProperty' => false,
            'otherDoc' => false,
            'otherDoc2' => false,
            'otherDoc3' => false,
            'otherDoc4' => false,
            'otherDoc5' => false,
            'otherDoc6' => false,
        ];

        $record->updated_at = date('Y-m-d H:i:s');

        $root = config('filesystems')['disks']['uploads']['root'];
        $path = date('/Y/m'). '/';
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
            $notify['CustGIDPicture1'] = true;

            $this->addText($root. $path. $filename);
        }
        if(isset($files['CustGIDPicture2'])) {
            if(trim($record->CustGIDPicture2) == '') {
                $ext = $files['CustGIDPicture2']->getClientOriginalExtension();
                $filename = $record->id. "_pic2.$ext";
                $record->CustGIDPicture2 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->CustGIDPicture2);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['CustGIDPicture2']->move($root. $path, $filename);
            $notify['CustGIDPicture2'] = true;

            $this->addText($root. $path. $filename);
        }
        if(isset($files['applyUploadPath'])) {
            if(trim($record->applyUploadPath) == '') {
                $ext = $files['applyUploadPath']->getClientOriginalExtension();
                $filename = $record->id. "_apply.$ext";
                $record->applyUploadPath = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->applyUploadPath);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['applyUploadPath']->move($root. $path, $filename);
            $notify['applyUploadPath'] = true;
        }
        if(isset($files['proofOfProperty'])) {
            if(trim($record->proofOfProperty) == '') {
                $ext = $files['proofOfProperty']->getClientOriginalExtension();
                $filename = $record->id. "_property.$ext";
                $record->proofOfProperty = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->proofOfProperty);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['proofOfProperty']->move($root. $path, $filename);
            $notify['proofOfProperty'] = true;

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][0])) {
            if(trim($record->otherDoc) == '') {
                $ext = $files['otherDoc'][0]->getClientOriginalExtension();
                $filename = $record->id. "_other.$ext";
                $record->otherDoc = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][0]->move($root. $path, $filename);
            $notify['otherDoc'] = true;

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][1])) {
            if(trim($record->otherDoc2) == '') {
                $ext = $files['otherDoc'][1]->getClientOriginalExtension();
                $filename = $record->id. "_other2.$ext";
                $record->otherDoc2 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc2);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][1]->move($root. $path, $filename);
            $notify['otherDoc2'] = true;

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][2])) {
            if(trim($record->otherDoc3) == '') {
                $ext = $files['otherDoc'][2]->getClientOriginalExtension();
                $filename = $record->id. "_other3.$ext";
                $record->otherDoc3 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc3);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][2]->move($root. $path, $filename);
            $notify['otherDoc3'] = true;

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][3])) {
            if(trim($record->otherDoc4) == '') {
                $ext = $files['otherDoc'][3]->getClientOriginalExtension();
                $filename = $record->id. "_other4.$ext";
                $record->otherDoc4 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc4);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][3]->move($root. $path, $filename);
            $notify['otherDoc4'] = true;

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][4])) {
            if(trim($record->otherDoc5) == '') {
                $ext = $files['otherDoc'][4]->getClientOriginalExtension();
                $filename = $record->id. "_other5.$ext";
                $record->otherDoc5 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc5);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][4]->move($root. $path, $filename);
            $notify['otherDoc5'] = true;

            $this->addText($root. $path. $filename);
        }
        if(isset($files['otherDoc'][5])) {
            if(trim($record->otherDoc6) == '') {
                $ext = $files['otherDoc'][5]->getClientOriginalExtension();
                $filename = $record->id. "_other6.$ext";
                $record->otherDoc6 = $path. $filename;
                $record->save();
            } else {
                $splitArr = preg_split("/\//", $record->otherDoc6);
                $path = $splitArr[0]. "/". $splitArr[1]. "/". $splitArr[2]. "/";
                $filename = $splitArr[3];
            }
            $files['otherDoc'][5]->move($root. $path, $filename);
            $notify['otherDoc6'] = true;

            $this->addText($root. $path. $filename);
        }
        $isNotify = false;
        foreach($notify as $item) {
            if($item == true)
                $isNotify = true;
        }
        if($isNotify) {
            $messageRepository = new MessageRepository();
            $messageRepository->additionalNotify($id, $notify);
        }
    }

    public function downloadAllImages($recordId) {
        $record = Record::where('id', '=', $recordId)
            ->first();
        if(isset($record->id) == false) {
            throw new Exception('案件不存在');
        }

        $account = Account::where('id', '=', $record->accountId)
            ->first();
        if(isset($account->id) == false) {
            throw new Exception('帳號不存在');
        }

        $uploadsRoot = config('filesystems')['disks']['uploads']['root'];
        $tempsRoot = config('filesystems')['disks']['temps']['root'];
        $seriesNum = 1;
        $files = [];
        $fileTemName = $record->submitId. '_'. $account->account;
        if(trim($record->CustGIDPicture1) != '') {
            $splitArr = preg_split("/\./", $record->CustGIDPicture1);
            $ext = $splitArr[count($splitArr)-1];
            $content = Storage::disk('uploads')->get($record->CustGIDPicture1);
            Storage::disk('temps')->put($fileTemName. "_$seriesNum.$ext", $content);
            array_push($files, $fileTemName. "_$seriesNum.$ext");
            ++$seriesNum;
        }
        if(trim($record->CustGIDPicture2) != '') {
            $splitArr = preg_split("/\./", $record->CustGIDPicture2);
            $ext = $splitArr[count($splitArr)-1];
            $content = Storage::disk('uploads')->get($record->CustGIDPicture2);
            Storage::disk('temps')->put($fileTemName. "_$seriesNum.$ext", $content);
            array_push($files, $fileTemName. "_$seriesNum.$ext");
            ++$seriesNum;
        }
        if(trim($record->applyUploadPath) != '') {
            $splitArr = preg_split("/\./", $record->applyUploadPath);
            $ext = $splitArr[count($splitArr)-1];
            $content = Storage::disk('uploads')->get($record->applyUploadPath);
            Storage::disk('temps')->put($fileTemName. "_$seriesNum.$ext", $content);
            array_push($files, $fileTemName. "_$seriesNum.$ext");
            ++$seriesNum;
        }
        if(trim($record->proofOfProperty) != '') {
            $splitArr = preg_split("/\./", $record->proofOfProperty);
            $ext = $splitArr[count($splitArr)-1];
            $content = Storage::disk('uploads')->get($record->proofOfProperty);
            Storage::disk('temps')->put($fileTemName. "_$seriesNum.$ext", $content);
            array_push($files, $fileTemName. "_$seriesNum.$ext");
            ++$seriesNum;
        }
        if(trim($record->otherDoc) != '') {
            $splitArr = preg_split("/\./", $record->otherDoc);
            $ext = $splitArr[count($splitArr)-1];
            $content = Storage::disk('uploads')->get($record->otherDoc);
            Storage::disk('temps')->put($fileTemName. "_$seriesNum.$ext", $content);
            array_push($files, $fileTemName. "_$seriesNum.$ext");
            ++$seriesNum;
        }
        if(trim($record->otherDoc2) != '') {
            $splitArr = preg_split("/\./", $record->otherDoc2);
            $ext = $splitArr[count($splitArr)-1];
            $content = Storage::disk('uploads')->get($record->otherDoc2);
            Storage::disk('temps')->put($fileTemName. "_$seriesNum.$ext", $content);
            array_push($files, $fileTemName. "_$seriesNum.$ext");
            ++$seriesNum;
        }
        if(trim($record->otherDoc3) != '') {
            $splitArr = preg_split("/\./", $record->otherDoc3);
            $ext = $splitArr[count($splitArr)-1];
            $content = Storage::disk('uploads')->get($record->otherDoc3);
            Storage::disk('temps')->put($fileTemName. "_$seriesNum.$ext", $content);
            array_push($files, $fileTemName. "_$seriesNum.$ext");
            ++$seriesNum;
        }
        if(trim($record->otherDoc4) != '') {
            $splitArr = preg_split("/\./", $record->otherDoc4);
            $ext = $splitArr[count($splitArr)-1];
            $content = Storage::disk('uploads')->get($record->otherDoc4);
            Storage::disk('temps')->put($fileTemName. "_$seriesNum.$ext", $content);
            array_push($files, $fileTemName. "_$seriesNum.$ext");
            ++$seriesNum;
        }
        if(trim($record->otherDoc5) != '') {
            $splitArr = preg_split("/\./", $record->otherDoc5);
            $ext = $splitArr[count($splitArr)-1];
            $content = Storage::disk('uploads')->get($record->otherDoc5);
            Storage::disk('temps')->put($fileTemName. "_$seriesNum.$ext", $content);
            array_push($files, $fileTemName. "_$seriesNum.$ext");
            ++$seriesNum;
        }
        if(trim($record->otherDoc6) != '') {
            $splitArr = preg_split("/\./", $record->otherDoc6);
            $ext = $splitArr[count($splitArr)-1];
            $content = Storage::disk('uploads')->get($record->otherDoc6);
            Storage::disk('temps')->put($fileTemName. "_$seriesNum.$ext", $content);
            array_push($files, $fileTemName. "_$seriesNum.$ext");
            ++$seriesNum;
        }

        $zip = new \ZipArchive();
        $zipArr = [];
        $zipArr['path'] = 'temps/'. $account->account. '.zip';
        $zipArr['name'] = $account->account. '.zip';
        $zipArr['count'] = count($files);
        if($zipArr['count'] == 0)
            throw new Exception('此案無上傳檔案');
        if($zip->open($zipArr['path'], \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
            foreach($files as $f) {
                $zip->addFile("temps/$f", "$f");
            }
            $zip->close();
            foreach($files as $f) {
                Storage::disk('temps')->delete($f);
            }
        } else {
            throw new Exception('zip open failed');
        }
        return $zipArr;
    }

    public function addText($filePath) {
        $extArr = preg_split("/\./", $filePath);
        $ext = $extArr[count($extArr) -1];
        $root = config('filesystems')['disks']['uploads']['root'];
        if(function_exists('imagecreatefromstring') == false) {
            throw new Exception('gd not extend');
        }
        $imgIntro = getimagesize($filePath);
        $imgWidth = $imgIntro[0];
        $imgHeight = $imgIntro[1];
        $thirdSide = sqrt(pow($imgWidth, 2) + pow($imgHeight, 2));
        
        $img = imagecreatefromstring(file_get_contents($filePath));
        $fontPath = "$root/mingliu.ttc";
        $fontColor = imagecolorallocatealpha($img, 0, 0, 0, 50);
        $fontSize = 20;
        $fontAngle = 0 - rad2deg(atan($imgHeight/$imgWidth));
        $fontLeft = 20;
        $fontTop = 20;

        $spaceAmount = (int) ($thirdSide / 7 / $fontSize) / 2;
        $textAmount = ceil($thirdSide / 400);
        //\Log::info("width: $imgWidth");
        //\Log::info("height: $imgHeight");
        //\Log::info("thirdSide: $thirdSide");
        //\Log::info("spaceAmount: $spaceAmount");
        $space = ' ';
        if ($imgWidth <= 300) {
            $fontLeft = 35;
            $fontTop = 35;
        }
        else if ($imgWidth > 2500) {
            $fontLeft = 450;
            $fontTop = 300;
        }
        else if ($thirdSide > 2500) {
            $fontLeft = 200;
            $fontTop = 200;
        }
            /*
            for($spaceIdx = 0;$spaceIdx < $spaceAmount;++$spaceIdx) {
                $space .= ' ';
            }
             */

        $fontText = implode($space, ['', '限','機','車','分','期','使','用']);
        for($textIdx = 0;$textIdx < $textAmount;++$textIdx) {
            $fontText .= $fontText;
        }
        imagefttext($img, $fontSize, $fontAngle, $fontLeft, $fontTop, $fontColor, $fontPath, $fontText);
        switch($ext) {
        case 'bmp':
            imagewbmp($img, $filePath);
            break;
        case 'gif':
            imagegif($img, $filePath);
            break;
        case 'jpg':
        case 'jpeg':
            imagejpeg($img, $filePath);
            break;
        case 'png':
            imagepng($img, $filePath);
            break;
        }
    }

    public function caseScheduleList($user, $params, $privileges) {
        $nowPage = isset($params['nowPage']) ? (int) $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? (int) $params['offset'] : 100;

        $recordQuery = Record::orderBy('CustAllowDenyTime', 'asc')
            ->skip(($nowPage-1) * $offset)
            ->take($offset);
        if(isset($params['keyword'])) {
            $recordQuery->where(function($query) use ($params) {
                $query->orWhere('CustName', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('AllowDenyDesc', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('SubIdName', 'like', '%'. $params['keyword']. '%');
            });
        }
        /*
        if($user->Privileges != "ALL") {
            $privileges = explode(',', $user->Privileges);
            $recordQuery->whereIn('SalesID', $privileges);
        }
         */
        $recordQuery->whereIn('SalesID', $privileges);
        $records = $recordQuery->get();
        foreach($records as $i => $record) {
            $recordAttr = $record->getAttributes();
            foreach($recordAttr as $key => $value) {
                if(is_null($value)) {
                    $records[$i]->{$key} = '';
                }
            }
        }
        return $records;
    }

    public function caseScheduleListAmount($user, $params, $privileges) {
        $recordQuery = Record::orderBy('CustAllowDenyTime', 'asc');
        if(isset($params['keyword'])) {
            $recordQuery->where(function($query) use ($params) {
                $query->orWhere('CustName', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('AllowDenyDesc', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('SubIdName', 'like', '%'. $params['keyword']. '%');
            });
        }
        /*
        if($user->Privileges != "ALL") {
            $privileges = explode(',', $user->Privileges);
            $recordQuery->whereIn('SalesID', $privileges);
        }
         */
        $recordQuery->whereIn('SalesID', $privileges);
        return $recordQuery->count();
    }

    public function caseSearchList($user, $params, $privileges) {
        $nowPage = isset($params['nowPage']) ? (int) $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? (int) $params['offset'] : 100;

        $orderName = "CustAllowDenyTime";
        $orderBy = "desc";
        if(isset($params['orderName']) && trim($params['orderName']) != '')
            $orderName = $params['orderName'];
        if(isset($params['orderBy']) && trim($params['orderBy']) != '')
            $orderBy = $params['orderBy'];
        $recordQuery = Record::orderBy($orderName, $orderBy)
            ->skip(($nowPage-1) * $offset)
            ->take($offset);
        if(isset($params['keyword']) && trim($params['keyword']) != '') {
            $recordQuery->where(function($query) use ($params) {
                $query->orWhere('CustName', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('AllowDenyDesc', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('SubIdName', 'like', '%'. $params['keyword']. '%');
            });
        }
        if(isset($params['customerKeyword'])) {
            $recordQuery->where(function($query) use ($params) {
                $query->orWhere('CustName', 'like', '%'. $params['customerKeyword']. '%');
                $query->orWhere('Plate', 'like', '%'. $params['customerKeyword']. '%');
                $query->orWhere('CustGID', 'like', '%'. $params['customerKeyword']. '%');
                $query->orWhere('SubIdName', 'like', '%'. $params['customerKeyword']. '%');
                $query->orWhere('SubIdSourceName', 'like', '%'. $params['customerKeyword']. '%');
            });
        }
        if(isset($params['CustProjectStatus']) && trim($params['CustProjectStatus']) != '') {
            if(trim($params['CustProjectStatus']) == '婉拒取消')
                $recordQuery->whereIn('CustProjectStatus', ['婉拒', '取消申辦']);
            else
                $recordQuery->where('CustProjectStatus', '=', trim($params['CustProjectStatus']));
        }
        if(isset($params['CustPayStatus']) && trim($params['CustPayStatus']) != '') {
            $recordQuery->where('CustPayStatus', '=', trim($params['CustPayStatus']));
        }
        if(isset($params['PayPageStatus']) && trim($params['PayPageStatus']) != '') {
            switch($params['PayPageStatus']) {
            case '全部':
                break;
            case '已撥款':
                $recordQuery->where('CustPayStatus', '=', '已撥款');
                break;
            case '缺資料未撥款':
                $recordQuery->where('DocumentMemo', '<>', '');
                break;
            case '資料已齊待撥款':
                $recordQuery->where('CustPayStatus', '=', '已撥款');
                $recordQuery->where('DocumentMemo', '=', '');
                break;
            }
        }
        if(isset($params['CaseCategoryType']) && trim($params['CaseCategoryType']) != '') {
            $recordQuery->where('CaseCategoryType', '=', trim($params['CaseCategoryType']));
        }
        /*
        if($user->Privileges != "ALL") {
            $privileges = explode(',', $user->Privileges);
            $recordQuery->whereIn('SalesID', $privileges);
        }
         */
        $recordQuery->whereIn('SalesID', $privileges);
        $records = $recordQuery->get();
        foreach($records as $i => $record) {
            $recordAttr = $record->getAttributes();
            foreach($recordAttr as $key => $value) {
                if(is_null($value)) {
                    $records[$i]->{$key} = '';
                }
            }
        }
        return $records;
    }

    public function caseSearchListAmount($user, $params, $privileges) {
        $orderName = "CustAllowDenyTime";
        $orderBy = "desc";
        if(isset($params['orderName']) && trim($params['orderName']) != '')
            $orderName = $params['orderName'];
        if(isset($params['orderBy']) && trim($params['orderBy']) != '')
            $orderBy = $params['orderBy'];
        $recordQuery = Record::orderBy($orderName, $orderBy);
        if(isset($params['keyword']) && trim($params['keyword']) != '') {
            $recordQuery->where(function($query) use ($params) {
                $query->orWhere('CustName', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('AllowDenyDesc', 'like', '%'. $params['keyword']. '%');
                $query->orWhere('SubIdName', 'like', '%'. $params['keyword']. '%');
            });
        }
        if(isset($params['customerKeyword'])) {
            $recordQuery->where(function($query) use ($params) {
                $query->orWhere('CustName', 'like', '%'. $params['customerKeyword']. '%');
                $query->orWhere('Plate', 'like', '%'. $params['customerKeyword']. '%');
                $query->orWhere('CustGID', 'like', '%'. $params['customerKeyword']. '%');
                $query->orWhere('SubIdName', 'like', '%'. $params['customerKeyword']. '%');
                $query->orWhere('SubIdSourceName', 'like', '%'. $params['customerKeyword']. '%');
            });
        }
        if(isset($params['CustProjectStatus']) && trim($params['CustProjectStatus']) != '') {
            if(trim($params['CustProjectStatus']) == '婉拒取消')
                $recordQuery->whereIn('CustProjectStatus', ['婉拒', '取消申辦']);
            else
                $recordQuery->where('CustProjectStatus', '=', trim($params['CustProjectStatus']));
        }
        if(isset($params['CustPayStatus']) && trim($params['CustPayStatus']) != '') {
            $recordQuery->where('CustPayStatus', '=', trim($params['CustPayStatus']));
        }
        if(isset($params['PayPageStatus']) && trim($params['PayPageStatus']) != '') {
            switch($params['PayPageStatus']) {
            case '全部':
                break;
            case '已撥款':
                $recordQuery->where('CustPayStatus', '=', '已撥款');
                break;
            case '缺資料未撥款':
                $recordQuery->where('DocumentMemo', '<>', '');
                break;
            case '資料已齊待撥款':
                $recordQuery->where('CustPayStatus', '=', '已撥款');
                $recordQuery->where('DocumentMemo', '=', '');
                break;
            }
        }
        if(isset($params['CaseCategoryType']) && trim($params['CaseCategoryType']) != '') {
            $recordQuery->where('CaseCategoryType', '=', trim($params['CaseCategoryType']));
        }
        /*
        if($user->Privileges != "ALL") {
            $privileges = explode(',', $user->Privileges);
            $recordQuery->whereIn('SalesID', $privileges);
        }
         */
        $recordQuery->whereIn('SalesID', $privileges);
        return $recordQuery->count();
    }
}

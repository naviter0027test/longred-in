<html>
    <head>
        <meta charset="utf-8">
        <title>長鴻管理系統</title>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
        <link href='/lib/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet' />
        <link href='/lib/bootstrap/dist/css/bootstrap-theme.min.css' rel='stylesheet' />
        <link href='/css/admin/body.css' rel='stylesheet' />
    </head>
    <body>
@include('admin.layout.menu')
        <div class="content">
            <h3>案件查詢 - 明細</h3>
            @if($result['result'] == false) 
            {{ $result['msg'] }}
            @else
            <form method='post' action='/admin/record/edit/{{ $result['record']->CustID }}' recordId="{{ $result['record']->CustID }}" class='form1' enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <h5>進件編號</h5>
                <p> {{ $result['record']->CustID }} </p>
                <h5>合約編號</h5>
                <p> <input type="text" name="CaseID" value="{{ $result['record']->CaseID }}" /> </p>
                <h5>申請人姓名</h5>
                <p> <input type="text" name="CustName" value="{{ $result['record']->CustName }}" /> </p>
                <h5>案件狀態</h5>
                <p>
                    <select name="CustProjectStatus">
                        <option value="處理中"  {{ $result['record']->CustProjectStatus == '處理中' ? 'selected="selected"' : '' }} >處理中  </option>
                        <option value="待核准"  {{ $result['record']->CustProjectStatus == '待核准' ? 'selected="selected"' : '' }} >待核准  </option>
                        <option value="核准"    {{ $result['record']->CustProjectStatus == '核准' ? 'selected="selected"' : '' }} >核准    </option>
                        <option value="取消申辦" {{ $result['record']->CustProjectStatus == '取消申辦' ? 'selected="selected"' : '' }} >取消申辦</option>
                        <option value="婉拒"    {{ $result['record']->CustProjectStatus == '婉拒' ? 'selected="selected"' : '' }} >婉拒    </option>
                    </select>
                </p>
                <h5>經銷商</h5>
                <p> <input type="text" name="SubId" value="{{ $result['record']->SubId }}" /> </p>
                <h5>案件來源代號</h5>
                <p> <input type="text" name="SubIdSource" value="{{ $result['record']->SubIdSource }}" /> </p>
                <h5>受款廠商代號</h5>
                <p> <input type="text" name="SubIdAcceptPayment" value="{{ $result['record']->SubIdAcceptPayment }}" /> </p>
                <h5>準駁日期</h5>
                <p> <input type="date" name="CustAllowDenyTime" value="{{ $result['record']->CustAllowDenyTimeVal }}" /> </p>
                <h5>商品型號</h5>
                <p> <input type="text" name="CarModelType" value="{{ $result['record']->CarModelType}}" /> </p>
                <h5>申貸金額</h5>
                <p> <input type="text" name="CustLoanCash" value="{{ $result['record']->CustLoanCash }}" /> </p>
                <h5>核貸金額</h5>
                <p> <input type="text" name="CustFinalDeposit" value="{{ $result['record']->CustFinalDeposit }}" /> </p>
                <h5>核准期數</h5>
                <p> <input type="number" name="Term" value="{{ $result['record']->Term }}" /> </p>
                <h5>期付金額</h5>
                <p> <input type="text" name="TermAmount" value="{{ $result['record']->TermAmount }}" /> </p>
                <h5>批單內容</h5>
                <p> <textarea type="text" name="AllowDenyDesc" >{{ $result['record']->AllowDenyDesc }}</textarea> </p>
                <h5>撥款狀態</h5>
                <p>
                    <select name="CustPayStatus">
                        <option value="" ></option>
                        <option value="核准" {{ $result['record']->CustPayStatus == '核准' ? 'selected="selected"' : '' }} >核准</option>
                        <option value="已撥款"   {{ $result['record']->CustPayStatus == '已撥款' ? 'selected="selected"' : '' }} >已撥款</option>
                    </select>
                </p>
                <h5>撥款日期</h5>
                <p> <input type="date" name="MoneyCloseDate" value="{{ $result['record']->MoneyCloseDateVal }}" /> </p>
                <h5>撥款金額</h5>
                <p> <input type="text" name="ActualPayCarRetailer" value="{{ $result['record']->ActualPayCarRetailer }}" /> </p>
                <h5>承辦廠商(經銷商)名稱</h5>
                <p> <input type="text" name="SubIdName" value="{{ $result['record']->SubIdName }}" /> </p>
                <h5>案件來源名稱</h5>
                <p> <input type="text" name="SubIdSourceName" value="{{ $result['record']->SubIdSourceName }}" /> </p>
                <h5>受款廠商名稱</h5>
                <p> <input type="text" name="SubIdAcceptPaymentName" value="{{ $result['record']->SubIdAcceptPaymentName }}" /> </p>
                <h5>車牌號碼</h5>
                <p> <input type="text" name="Plate" value="{{ $result['record']->Plate }}" /> </p>
                <h5>動產設定或說明</h5>
                <p> <input type="text" name="CustProjectCategory" value="{{ $result['record']->CustProjectCategory }}" /> </p>
                <h5>承辦廠商區域</h5>
                <p> <input type="text" name="SubArea" value="{{ $result['record']->SubArea }}" /> </p>
                <h5>進件日期</h5>
                <p> <input type="date" name="CustCreateTime" value="{{ $result['record']->CustCreateTimeVal }}" /> </p>
                <h5>商品名稱</h5>
                <p> <input type="text" name="CarModelName" value="{{ $result['record']->CarModelName }}" /> </p>
                <h5>身分證字號</h5>
                <p> <input type="text" name="CustGID" value="{{ $result['record']->CustGID }}" /> </p>
                <h5>AppID</h5>
                <p> <input type="text" name="AppID" value="{{ $result['record']->AppID }}" /> </p>
                <h5>尚欠資料(文件歸檔備註)</h5>
                <p> <input type="text" name="DocumentMemo" value="{{ $result['record']->DocumentMemo }}" /> </p>
                <h5>專業別</h5>
                <p> <input type="text" name="CustFinalProjectID" value="{{ $result['record']->CustFinalProjectID }}" /> </p>
                <h5>管銷手續費</h5>
                <p> <input type="text" name="CustFee" value="{{ $result['record']->CustFee }}" /> </p>
                <h5>待補事項</h5>
                <p> <input type="text" name="CustWaitCheckItem" value="{{ $result['record']->CustWaitCheckItem }}" /> </p>
                <h5>申請書寄回日</h5>
                <p> <input type="date" name="ApplicationReceivedDate" value="{{ $result['record']->ApplicationReceivedDateVal }}" /> </p>
                <h5>行照回傳日</h5>
                <p> <input type="date" name="LicenseReceivedDate" value="{{ $result['record']->LicenseReceivedDateVal }}" /> </p>
                <h5>換補照日</h5>
                <p> <input type="date" name="RenewalLicenseDate" value="{{ $result['record']->RenewalLicenseDateVal }}" /> </p>
                <h5>For業務備註(黃批)</h5>
                <p> <textarea type="text" name="ForSalesMemo" >{{ $result['record']->ForSalesMemo }}</textarea> </p>
                <h5>設定費</h5>
                <p> <input type="text" name="VehicleLoanFeeIn" value="{{ $result['record']->VehicleLoanFeeIn }}" /> </p>
                <h5>保險專案</h5>
                <p> <input type="text" name="Insurance" value="{{ $result['record']->Insurance }}" /> </p>
                <h5>業務ID</h5>
                <p> <input type="text" name="SalesID" value="{{ $result['record']->SalesID }}" /> </p>
                <h5>業務名</h5>
                <p> <input type="text" name="SalesName" value="{{ $result['record']->SalesName }}" /> </p>
                <h5>首期繳款日</h5>
                <p> <input type="date" name="FirstPayDate" value="{{ $result['record']->FirstPayDateVal }}" /> </p>
                <h5>帳單地址</h5>
                <p> <input type="text" name="CustBillAddress" value="{{ $result['record']->CustBillAddress }}" /> </p>
                <h5>帳單郵寄日</h5>
                <p> <input type="date" name="BillSendDate" value="{{ $result['record']->BillSendDateVal }}" /> </p>
                <h5>ATM帳號</h5>
                <p> <input type="text" name="ATMAccount" value="{{ $result['record']->ATMAccount }}" /> </p>
                <h5>案件類別</h5>
                <p> <input type="text" name="CaseCategoryType" value="{{ $result['record']->CaseCategoryType }}" /> </p>
                <h5>申請書類別</h5>
                <p> <input type="text" name="ApplicationType" value="{{ $result['record']->ApplicationType }}" /> </p>
<!--
                <p class=""> <button class="btn">更改</button> </p>
-->
            </form>

<!--
            <div class="leaveMessage">
                <h4>留言</h4>
                <div class="leaveMsgDiv">
                    <h5>申請者:</h5>
                    <p> 這究得飛料民了然興何？腦見著作需益黃我出手岸 </p>
                    <h5>管理者:</h5>
                    <p> 積門當應各手的如的使美起有麼在生中個在 </p>
                </div>
                <form action="/admin/message/send" method="post" class="replyMsg">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="recordId" value="{{ $result['record']->id }}" />
                    <p class=""> <textarea name="content"></textarea> </p>
                    <p class=""> <button class="btn">回覆</button> </p>
                </form>
            </div>
-->
            @endif
        </div>
    </body>
    <script src="/lib/jquery-2.1.4.min.js"></script>
    <script src="/js/admin/record/edit.js"></script>
</html>

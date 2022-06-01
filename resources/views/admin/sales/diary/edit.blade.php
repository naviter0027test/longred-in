<html>
    <head>
        <meta charset="utf-8">
        <title>長鴻管理系統</title>
        <link href='/lib/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet' />
        <link href='/lib/bootstrap/dist/css/bootstrap-theme.min.css' rel='stylesheet' />
        <link href='/lib/selectize.js-master/dist/css/selectize.default.css' rel='stylesheet' />
        <link href='/css/admin/body.css' rel='stylesheet' />
    </head>
    <body>
@include('admin.layout.menu')
        <div class="content">
            <h3>工作日誌 - 編輯</h3>
            @if($result['result'] == false) 
            {{ $result['msg'] }}
            @else
            <form method='post' action='/admin/sales/diary/edit/{{ $result['diary']->WorkMemoID }}' class='form1' enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <h5>廠商名稱</h5>
                <p> <input type="hidden" name="SubName" value="{{ $result['diary']->SubName }}" /> 
                    <select name="SubId">
                    @foreach($result['companies'] as $company)
                        <option value="{{ $company->UserId }}"
                    @if($result['diary']->SubId == $company->UserId)
                        selected
                    @endif
                        >{{ $company->UserName }}</option>
                    @endforeach
                    </select>
                </p>
                <h5>參觀日期</h5>
                <p> <input type="date" name="VisitDate" value="{{ $result['diary']->VisitDate }}" /> </p>
                <h5>業務名稱</h5>
                <p> <!--input type="text" name="SalesName" value="{{ $result['diary']->SalesName}}" /--> 
                    <select name="SalesName">
                    @foreach($result['users'] as $user)
                        <option value="{{ $user->UserName }}"
                    @if($result['diary']->SalesName == $user->UserName)
                        selected
                    @endif
                        >{{ $user->UserName }}</option>
                    @endforeach
                    </select>
                </p>
                <h5>日誌內容</h5>
                <p> <textarea type="text" name="WorkMemo" >{{ $result['diary']->WorkMemo }}</textarea> </p>
                <p class=""> <button class="btn">更改</button> </p>
            </form>

            @endif
        </div>
    </body>
    <script src="/lib/jquery-2.1.4.min.js"></script>
    <script src="/lib/selectize.js-master/dist/js/standalone/selectize.js"></script>
    <script src="/js/admin/diary/edit.js"></script>
</html>

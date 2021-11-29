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
            <h3>廠商 - 明細</h3>
            @if($result['result'] == false) 
            {{ $result['msg'] }}
            @else
            <form method='post' action='/admin/companies/edit/{{ $result['company']->id }}' companyId="{{ $result['company']->id }}" class='form1' enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <h5>UserId</h5>
                <p> {{ $result['company']->UserId }} </p>
                <h5>密碼</h5>
                <p> <input type="text" name="Password" value="{{ $result['company']->Password }}" /> </p>
                <h5>廠商名稱</h5>
                <p> <input type="text" name="UserName" value="{{ $result['company']->UserName }}" /> </p>
                <p class=""> <button class="btn">更改</button> </p>
            </form>

            @endif
        </div>
    </body>
    <script src="/lib/jquery-2.1.4.min.js"></script>
    <script src="/js/admin/company/edit.js"></script>
</html>

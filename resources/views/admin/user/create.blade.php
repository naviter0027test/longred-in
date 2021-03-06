<html>
    <head>
        <meta charset="utf-8">
        <title>長鴻管理系統</title>
        <!--meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"-->
        <link href='/lib/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet' />
        <link href='/lib/bootstrap/dist/css/bootstrap-theme.min.css' rel='stylesheet' />
        <link href='/lib/selectize.js-master/dist/css/selectize.default.css' rel='stylesheet' />
        <link href='/css/admin/body.css' rel='stylesheet' />
    </head>
    <body>
@include('admin.layout.menu')
        <div class="content">
            <h3>使用者 - 新增</h3>
            <form method='post' action='/admin/account/create' class='form1' enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <h5>帳號</h5>
                <p> <input type="text" name="UserId" required /> </p>
                <h5>密碼</h5>
                <p> <input type="password" name="Password" required /> </p>
                <h5>名稱</h5>
                <p> <input type="text" name="UserName" /> </p>
                <h5>區域</h5>
                <p> <input type="text" name="Area" /> </p>
                <h5>權限</h5>
                <p>
                    全部 <input type="checkbox" name="isPrivilegesAll" value="ALL" />
                    <select type="text" name="Privileges[]" multiple> 
                    @foreach($result['users'] as $user)
                        <option value="{{ $user->UserId }}">{{ $user->UserName }}</option>
                    @endforeach
                    </select>
                </p>
                <p class=""> <button class="btn">新增</button> </p>
            </form>
        </div>
    </body>
    <script src="/lib/jquery-2.1.4.min.js"></script>
    <script src="/lib/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="/lib/jquery-validation/dist/additional-methods.min.js"></script>
    <script src="/lib/jquery-validation/dist/localization/messages_zh_TW.min.js"></script>
    <script src="/lib/selectize.js-master/dist/js/standalone/selectize.js"></script>
    <script src="/js/admin/account/create.js"></script>
</html>


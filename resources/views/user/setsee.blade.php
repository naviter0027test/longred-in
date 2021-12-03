<html>
    <head>
        <meta charset="utf-8">
        <title>長鴻系統</title>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
        <link href='/lib/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet' />
        <link href='/lib/bootstrap/dist/css/bootstrap-theme.min.css' rel='stylesheet' />
        <link href='/css/web/body.css' rel='stylesheet' />
    </head>
    <body>
        <div class="content">
            <h3>權限 : 設定現在要看哪些業務員API模擬頁面</h3>
            <form method="post" action="/user/privileges/setsee" class="form1" enctype="multipart/form-data">
                <h5>權限:</h5>
                <p> <input type="text" name="privileges[]" /> </p>
                <p> <input type="text" name="privileges[]" /> </p>
                <p> <input type="text" name="privileges[]" /> </p>
                <p> <input type="text" name="privileges[]" /> </p>
                <p> <input type="text" name="privileges[]" /> </p>
                <p class=""> <button class="btn">確定</button> </p>
            </form>
        </div>
    </body>
    <script src="/lib/jquery-2.1.4.min.js"></script>
    <script src="/js/admin/login.js"></script>
</html>

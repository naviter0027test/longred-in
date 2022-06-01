<html>
    <head>
        <meta charset="utf-8">
        <title>長鴻內部業務管理系統</title>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
        <link href='/lib/bootstrap/dist/css/bootstrap.min.css' rel='stylesheet' />
        <link href='/lib/bootstrap/dist/css/bootstrap-theme.min.css' rel='stylesheet' />
        <link href='/css/web/body.css' rel='stylesheet' />
    </head>
    <body>
        <div class="content">
            <h3>工作日誌 - 新增</h3>
            <form method='post' action='/user/sales/diary/create' class='form1' enctype="multipart/form-data">
                <h5>SubId</h5>
                <p> <input type="text" name="SubId" required /> </p>
                <h5>VisitDate</h5>
                <p> <input type="date" name="VisitDate" /> </p>
                <h5>工作日誌內容</h5>
                <p> <textarea name="WorkMemo" ></textarea> </p>
                <p class=""> <button class="btn">新增</button> </p>
            </form>
        </div>
    </body>
    <script src="/lib/jquery-2.1.4.min.js"></script>
</html>

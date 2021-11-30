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
            <h3>保險查詢API模擬頁面</h3>
            <form method='post' action='/user/case/insurance' class='form1' enctype="multipart/form-data">
                <h5>關鍵字查詢</h5>
                <p>
                    <input type="text" name="keyword" placeholder="關鍵字查詢" value="" />
                </p>
                <h5>案件類別</h5>
                <p> 
                    <select name="CaseCategoryType" > 
                        <option value=""></option>
                        <option value="精品維修">精品維修</option>
                        <option value="一般">一般</option>
                        <option value="預購車">預購車</option>
                    </select>
                </p>
                <h5>第幾頁</h5>
                <p>
                    <input type="number" name="nowPage" value="1" />
                </p>
                <h5>一頁顯示數量</h5>
                <p>
                    <input type="number" name="offset" value="10" />
                </p>
                <p class=""> <button class="btn">查詢</button> </p>
            </form>
        </div>
    </body>
    <script src="/lib/jquery-2.1.4.min.js"></script>
</html>

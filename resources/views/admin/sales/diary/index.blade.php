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
            <h3>工作日誌查詢</h3>
            <div class="nav">
                <form method="get" action="/admin/sales/diary" enctype="multipart/form-data" class="searchBar">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="text" name="keyword" placeholder="關鍵字查詢" value="{{ isset($params['keyword']) ? $params['keyword'] : '' }}" />
                    <button class="btn">查詢</button>
                </form>
            </div>
            <table class="table1">
                <thead>
                    <tr>
                        <td>廠商名稱</td>
                        <td>參觀日期</td>
                        <td>業務員名稱</td>
                        <td>內容</td>
                        <td>建立日期</td>
                        <td>操作</td>
                    </tr>
                </thead>
                <tbody>
                @if(isset($result['diaries']))
                @foreach($result['diaries'] as $diary)
                    <tr>
                        <td>{{ $diary->SubName }}</td>
                        <td>{{ $diary->VisitDate }}</td>
                        <td>{{ $diary->SalesName }}</td>
                        <td>{{ $diary->WorkMemo }}</td>
                        <td>{{ $diary->CreateDate }}</td>
                        <td>
                            <a href='/admin/sales/diary/edit/{{ $diary->WorkMemoID }}' class="glyphicon glyphicon-pencil"></a>
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </table>

            <div class="pagination paginationCenter">
            @if(isset($result['amount']))
            @for($i = 0; $i < ceil($result['amount'] / $offset); ++$i)
                @if(($i+1) == $nowPage)
                <label>{{ $i+1 }}</label>
                @elseif(($i+1) != $nowPage && abs($i+1-$nowPage) < 5)
                <a href="/admin/record/?nowPage={{ $i+1 }}&{{ http_build_query($params) }}">{{ $i+1 }}</a>
                @endif
            @endfor
            @endif
            </div>
        </div>
    </body>
    <script src="/lib/jquery-2.1.4.min.js"></script>
    <script src="/js/admin/record/index.js"></script>
</html>


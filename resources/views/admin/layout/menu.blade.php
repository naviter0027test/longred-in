<div class="admin-bar">
    <span>長鴻內部業務系統</span>
    <div class="tool-right">
        <a href="/admin/logout">登出</a>
    </div>
</div>

<div class="admin-menu">
    <div class="menu1">
        <a href="/admin/home" class="{{ strpos(\Request::path(), 'admin/home') === false ? '' : 'clicked' }} glyphicon glyphicon-bell">
        首頁</a>
    </div>
    <div class="menu1">
        <a href="/admin/setting" class="{{ strpos(\Request::path(), 'admin/setting') === false ? '' : 'clicked' }} glyphicon glyphicon-lock">
        密碼更改</a>
    </div>
    <div class="menu1">
        <a href="/admin/record" class="{{ strpos(\Request::path(), 'admin/record') === false ? '' : 'clicked' }} glyphicon glyphicon-th-list">
        案件查詢</a>
    </div>
    <div class="menu1">
        <a href="/admin/account" class="{{ strpos(\Request::path(), 'admin/account') === false ? '' : 'clicked' }} glyphicon glyphicon-user">
        使用者管理</a>
    </div>
    <div class="menu1">
        <a href="/admin/companies" class="{{ strpos(\Request::path(), 'admin/companies') === false ? '' : 'clicked' }} glyphicon glyphicon-user">
        廠商管理</a>
    </div>
    <div class="menu1">
        <a href="/admin/sales/diary" class="{{ strpos(\Request::path(), 'admin/sales/diary') === false ? '' : 'clicked' }} glyphicon glyphicon-user">
        工作日誌管理</a>
    </div>
</div>

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/admin/login');
});

/*
Route::group(['prefix' => 'front'], function() {
    Route::get('forget', 'FrontController@forget');
    Route::get('login', 'FrontController@login');
    Route::get('home', 'FrontController@home');
    Route::get('create', 'FrontController@create');
    Route::get('search', 'FrontController@search');
    Route::get('appropriation', 'FrontController@appropriation');
    Route::get('process', 'FrontController@process');
    Route::get('wait', 'FrontController@wait');
    Route::get('agree', 'FrontController@agree');
    Route::get('degree', 'FrontController@degree');
    Route::get('cancel', 'FrontController@cancel');

    Route::get('modify', 'FrontController@modify');
    Route::get('message', 'FrontController@message');
    Route::get('record', 'FrontController@record');
    Route::get('news', 'FrontController@news');
    Route::get('news-id/{id}', 'FrontController@newsItem');
});

Route::get('/fcm-test', 'AccountController@fcmTest');
 */

Route::group(['middleware' => ['check.account']], function() {

    /*
    Route::get('/application', function () {
        return view('application');
    });
    Route::post('/application/create', 'ApplicationController@create');
    Route::get('/application/create', function () {
        return view('application');
    });
    Route::post('/application/cancel', 'ApplicationController@cancel');
    Route::get('/application/cancel', 'ApplicationController@cancelPage');
    Route::post('/application/update', 'ApplicationController@update');
    Route::get('/application/update', 'ApplicationController@updatePage');
     */

    Route::group(['prefix' => 'user'], function() {
        Route::get('login', 'UserController@loginPage');
        Route::post('login', 'UserController@login');
        Route::get('logout', 'UserController@logout');
        Route::get('get', 'UserController@getMyData');
        Route::get('privileges', 'UserController@privileges');
        Route::get('privileges/setsee', 'UserController@privilegesSetSeePage');
        Route::post('privileges/setsee', 'UserController@privilegesSetSee');
        Route::get('privileges/getsee', 'UserController@privilegesGetSee');
        /*
        Route::get('apple-token/set', 'UserController@appleTokenSetPage');
        Route::post('apple-token/set', 'UserController@appleTokenSet');
        Route::get('apple-token/get', 'UserController@appleTokenGet');
         */

        Route::get('case/schedule', 'RecordController@caseSchedulePage');
        Route::post('case/schedule', 'RecordController@caseSchedule');
        Route::get('case/search', 'RecordController@caseSearchPage');
        Route::post('case/search', 'RecordController@caseSearch');
        Route::get('case/pay', 'RecordController@caseCustPayPage');
        Route::post('case/pay', 'RecordController@caseCustPay');
        Route::get('case/insurance', 'RecordController@caseInsurancePage');
        Route::post('case/insurance', 'RecordController@caseInsurance');
        Route::get('case/preorder', 'RecordController@casePreorderPage');
        Route::post('case/preorder', 'RecordController@casePreorder');
        Route::get('case/customer', 'RecordController@caseCustomerPage');
        Route::post('case/customer', 'RecordController@caseCustomer');
        Route::get('companies', 'CompanyController@indexPage');
        Route::post('companies', 'CompanyController@index');
        Route::get('sales/diary/create', 'SalesWorkDiaryController@createPage');
        Route::post('sales/diary/create', 'SalesWorkDiaryController@create');

        Route::get('staging', 'StagingController@indexPage');
        Route::post('staging', 'StagingController@index');
        Route::get('staging/upload', 'StagingController@uploadPage');
        Route::post('staging/upload', 'StagingController@upload');
        Route::get('staging/remove/{id}', 'StagingController@remove');

        Route::get('messages', 'MessageController@listsPage');
        Route::get('message', 'MessageController@listsByUserId');
        Route::get('message/read', 'MessageController@readPage');
        Route::post('message/read', 'MessageController@read');
        Route::get('message/send', 'MessageController@sendPage');
        Route::post('message/send', 'MessageController@send');
        Route::get('message/record-id', 'MessageController@getByRecordIdPage');
        Route::post('message/record-id', 'MessageController@getByRecordId');
    });

    Route::get('/api/help', 'AccountController@apiHelp');
});
Route::group(['prefix' => 'user'], function() {
    Route::get('isLogin', 'UserController@isLogin');
    Route::get('forget', 'UserController@forgetPage');
    Route::post('forget', 'UserController@forget');
});

/*
Route::group(['prefix' => 'telegram'], function() {
    Route::any('test', 'TelegramController@test');
    Route::get('login', 'TelegramController@login');
});
 */

Route::group(['prefix' => 'admin', 'middleware' => ['check.login']], function() {

    Route::get('login', 'Admin\UserController@loginPage');
    Route::post('login', 'Admin\UserController@login');

    Route::get('home', 'Admin\UserController@home');
    Route::get('setting', 'Admin\UserController@passAdmin');
    Route::post('setting', 'Admin\UserController@passUpdate');

    Route::get('companies', 'Admin\CompanyController@index');
    Route::post('companies', 'Admin\CompanyController@index');
    Route::get('companies/create', 'Admin\CompanyController@createPage');
    Route::post('companies/create', 'Admin\CompanyController@create');
    Route::get('companies/edit/{id}', 'Admin\CompanyController@edit');
    Route::post('companies/edit/{id}', 'Admin\CompanyController@update');
    Route::get('companies/remove/{id}', 'Admin\CompanyController@remove');

    Route::get( 'account', 'Admin\AccountController@lists');
    Route::post( 'account', 'Admin\AccountController@lists');
    Route::get( 'account/create', 'Admin\AccountController@createPage');
    Route::post('account/create', 'Admin\AccountController@create');
    Route::get( 'account/edit/{id}', 'Admin\AccountController@edit');
    Route::post('account/edit/{id}', 'Admin\AccountController@update');
    Route::get( 'account/remove/{id}', 'Admin\AccountController@remove');

    Route::get('record', 'Admin\RecordController@index');
    Route::post('record', 'Admin\RecordController@index');
    Route::post('record/import', 'Admin\RecordController@import');
    Route::get('record/edit/{id}', 'Admin\RecordController@edit');
    /*
    Route::post('record/edit/{id}', 'Admin\RecordController@update');
    Route::get('record/edit/download/{id}', 'Admin\RecordController@downloadAllImages');
    Route::get('record/remove/{id}', 'Admin\RecordController@remove');
    Route::get('grant', 'Admin\RecordController@grant');

    Route::get('message/record/{id}', 'Admin\MessageController@getByRecordId');
    Route::post('message/send', 'Admin\MessageController@send');

    Route::get('news', 'Admin\MessageController@getNews');
    Route::get('news/create', 'Admin\MessageController@createNewPage');
    Route::post('news/create', 'Admin\MessageController@createNew');
    Route::get('news/edit/{id}', 'Admin\MessageController@editNewPage');
    Route::post('news/edit/{id}', 'Admin\MessageController@editNew');
    Route::get( 'news/remove/{id}', 'Admin\MessageController@removeNew');

    Route::get('announcement', 'Admin\MessageController@getAnnouncement');
    Route::get('announcement/create', 'Admin\MessageController@createAnnouncementPage');
    Route::post('announcement/create', 'Admin\MessageController@createAnnouncement');
    Route::get('announcement/edit/{id}', 'Admin\MessageController@editAnnouncementPage');
    Route::post('announcement/edit/{id}', 'Admin\MessageController@editAnnouncement');
    Route::get( 'announcement/remove/{id}', 'Admin\MessageController@removeAnnouncement');
     */

    Route::get('logout', 'Admin\UserController@logout');
});

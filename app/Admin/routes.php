<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\CustomersController;
use App\Admin\Controllers\MediaCategoryController;
use App\Models\MediaCategory;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    //客户及媒体
    $router->get('/', 'HomeController@index');
    $router->resource('customer', CustomerController::class);
    $router->resource('media/index', MediaController::class);
    $router->resource('media/channel', ChannelController::class);
    $router->resource('media/category',CategoryController::class);
    $router->resource('media/leader',LeaderController::class);

    //业务流量数据
    $router->get('trade', 'TradeController@index');
    Route::get('trade/create','TradeController@create');
    Route::get('trade/{id}/edit','TradeController@show');
    Route::any('trade/check','TradeController@check');
    Route::get('trade/check/{id}/edit','TradeController@show'); 
    $router->post('trade/index', 'TradeController@index');
    $router->post('trade/check/checkupdate', 'TradeController@checkUpdate');
  
    //excel导入
    $router->get('exceltrade/import', 'ImportExcelController@import');
    $router->post('exceltrade/check', 'ImportExcelController@check');
    $router->post('exceltrade/save', 'ImportExcelController@saveExcel');
    
    //财务及相关报表
    $router->resource('finance',FinanceController::class);       
    Route::any('report/receive','ReceiveReportController@getCustomerReceived');
    Route::post('report/receiveupdate','ReceiveReportController@receiveUpdate');
    Route::get('report/tradedetails','ReceiveReportController@getTadeDetails');   
    Route::any('report/paid','PaidReportController@getMediaReceived');
    Route::post('report/paidupdate','PaidReportController@paidUpdate');
    Route::get('report/day','ReportController@getDayReport');
    Route::get('report/notice','ReportController@getReportNotice');
     
});

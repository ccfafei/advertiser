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

    //客户
    $router->get('/', 'HomeController@index');
    $router->resource('customer', CustomerController::class);

    //网络媒体
    $router->resource('media', MediaController::class);
    Route::post('media/index', 'MediaController@index')->name('media.search');
    $router->resource('mediachannel', ChannelController::class);
    $router->resource('mediacategory',CategoryController::class);
    $router->resource('medialeader',LeaderController::class);
    
    //微博
    Route::post('weibo/index', 'WeiboController@index')->name('weibo.search');
    $router->resource('weibo', WeiboController::class);
    $router->resource('weibocategory', CategoryWeiboController::class);
    $router->resource('weiboleader', LeaderWeiboController::class);
    

    //业务流量数据
    Route::get('trade', 'TradeController@index')->name('trade.index');
    Route::get('trade/create','TradeController@create')->name('trade.create');
    Route::get('trade/{id}/edit','TradeController@show')->name('trade.edit');
    Route::any('trade/check','TradeController@check')->name('trade.check');
    Route::get('trade/check/{id}/edit','TradeController@show')->name('trade.update'); 
    $router->post('trade/index', 'TradeController@index')->name('trade.search');
    Route::post('trade/checkupdate', 'TradeController@checkUpdate')->name('trade.checkupdate');
    Route::post('trade/receiveupdate','TradeControllerController@receiveUpdate')->name('receive.update');
    Route::post('trade/paidupdate','TradeController@paidUpdate')->name('paid.update');
    
  
    //excel导入
    $router->get('exceltrade/import', 'ImportExcelController@import')->name('excel.import');
    $router->post('exceltrade/check', 'ImportExcelController@check')->name('excel.check');
    $router->post('exceltrade/save', 'ImportExcelController@saveExcel')->name('excel.save');
    
    //财务及相关报表
    $router->resource('finance',FinanceController::class);       
    Route::any('report/receive','ReceiveReportController@getCustomerReceived')->name('report.receive');
    Route::get('report/tradedetails','ReceiveReportController@getTadeDetails')->name('report.trade');   
    Route::any('report/paid','PaidReportController@getMediaReceived')->name('report.paid');
    Route::get('report/day','ReportController@getDayReport')->name('report.day');
    Route::get('report/notice','ReportController@getReportNotice')->name('report.notice');
     
});

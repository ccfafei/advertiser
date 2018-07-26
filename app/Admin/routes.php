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

    $router->get('/', 'HomeController@index');
    $router->resource('customer', CustomerController::class);
    $router->resource('media/index', MediaController::class);
    $router->resource('media/channel', ChannelController::class);
    $router->resource('media/category',CategoryController::class);
    $router->resource('media/leader',LeaderController::class);
    Route::get('trade','TradeController@index');
    Route::get('trade/create','TradeController@create');
    Route::get('trade/{id}/edit','TradeController@show');
    Route::any('trade/check','TradeController@check');
    Route::get('trade/check/{id}/edit','TradeController@show'); 
    $router->post('trade/index', 'TradeController@index');
    $router->post('trade/check/checkupdate', 'TradeController@checkUpdate');
  
    $router->get('exceltrade/import', 'ImportExcelController@import');
    $router->post('exceltrade/check', 'ImportExcelController@check');
    $router->post('exceltrade/save', 'ImportExcelController@saveExcel');
    $router->resource('finance',FinanceController::class);
   
   
});

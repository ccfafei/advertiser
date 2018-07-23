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
    $router->resource('trade',TradeController::class);
    $router->resource('finance',FinanceController::class);
    $router->post('trade/index', 'TradeController@index');
    $router->get('exceltrade/import', 'ImportExcelController@import');
    $router->post('exceltrade/check', 'ImportExcelController@check');
    $router->post('exceltrade/save', 'ImportExcelController@saveExcel');
   
   
});

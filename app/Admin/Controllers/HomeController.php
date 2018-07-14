<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    
    public function index(){
        return Admin::content(function (Content $content) {
        
            $content->header('首页');
            $content->description('');
        
            $content->body(view('admin.charts.bar'));
        });
    }
    
    //系统信息
    public function system()
    {
        return Admin::content(function (Content $content) {

            $content->header('系统');
            $content->description('系统信息...');

            $content->row(Dashboard::title());

            $content->row(function (Row $row) {

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });

                $row->column(4, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
            
        });
    }
}

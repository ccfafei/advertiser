<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use App\Admin\Controllers\ReportController;

class HomeController extends Controller
{
    
    public function index(){
        return Admin::content(function (Content $content) {
        
            $content->header('后台首页');
            $content->description('数据中心');
            $report = new ReportController();
            $notices = $report->getReportNotice();  
            $data =  $report->getDayReport();  
            $charts = []; 
            foreach ($data as $k=>$v){
                $charts['day'][] = date('m月d日',$v['day']);
                $charts['customer_price'][] = $v['customer_price'];
                $charts['media_price'][] = $v['media_price'];
                $charts['profit'][] = $v['profit'];
            } 
            $items =json_encode($charts);            
            $content->body(view('admin.charts.bar',compact('notices','items')));
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

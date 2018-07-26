<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Finance;
use App\Models\Trade;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
   use ModelForm;
   
   //待回款,按时间，客户名称汇总，汇总时该条记录必须被审核
   public function getCustomerReceived(Request $request ){
      return Admin::content(function (Content $content) use($request) {
          $model = new Trade();
          $model = $model->where(['is_check'=>1,'is_received'=>0]);
          //客户姓名
          if($request->has('customer_name')){
              $customer_name = $request->input('customer_name');
              $model = model->where('customer_name','like','%'.$customer_name.'%');
          }
          
          //开始时间
          if($request->has('start_day')){
              $start_day= strtotime($request->input('start_day'));
              $model = model->where('trade_ts','>=',$start_day);
          }
          
          //结束时间
          if($request->has('end_day')){
              $end_day= strtotime($request->input('end_day'));
              $model = model->where('trade_ts','>=',$end_day);
          }
          $model = $model->select(
              DB::raw('FROM_UNIXTIME(trade_ts, '%Y-%m-%d') AS trade_ts '),
              'customer_id',
              'customer_name',
              DB::raw('SUM(customer_price) AS customer_price '),
              'is_received', 
              'created_at'         
             
            )
           ->groupBy('trade_ts','customer_name')
           ->orderBy('trade_ts','desc')
           ->get()
           
           if($model->isNotEmpty()){
               $rows = $model->toArray();
           }
           $receiveds = config('trade.is_received');
           $prices = $customer_prices = $media_prices = $profits = 0;
           foreach ($rows as $key=>$items){
               $rows[$key]['is_received'] = $receiveds[(int)$items['is_received']];
               $customer_prices += $items['customer_price'];//报价
           }
           $arrsum =['customer_prices'=>$customer_prices];
           $exporturl = $this->grid()->exportUrl('all');
           $url = $exporturl;
           $listview = view('admin.trade.list',compact('rows','headers','checks','url','inputs','arrsum'))->render();
           $content->row($listview);
      });
   }

    
}

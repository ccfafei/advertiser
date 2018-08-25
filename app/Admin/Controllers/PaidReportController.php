<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Trade;
use Illuminate\Support\Facades\DB;
use App\Admin\Controllers\Base;
use Encore\Admin\Auth\Permission;

class PaidReportController extends Controller
{
   use ModelForm;
   
   //按时间，媒体名称,出款状态汇总，汇总时该条记录必须被审核
   public function getMediaReceived(Request $request ){
      return Admin::content(function (Content $content) use($request) {
          Permission::check('report.view');
          $content->header('媒体出款报表');
          $content->description('付款');
          $model = new Trade();
          $model = $model->where('is_check',1);
          
          //客户姓名
          if($request->has('media_name')){
              $media_name = $request->input('media_name');
              $model = $model->where('media_name','like','%'.$media_name.'%');
          }

          if ($request->has('month')) {
              $month_start = $request->input('month');
              $model = $model->where( DB::raw(' FROM_UNIXTIME(trade_ts,"%Y-%m")'), $month_start);
          }

           //状态选择
          if($request->has('is_paid') && $request->input('is_paid')!='all'){
              $is_paid= $request->input('is_paid');
              $model = $model->where('is_paid',(int)$is_paid);
          }
        
          
          //查询
          $model = $model->select(
              DB::raw(' FROM_UNIXTIME(trade_ts,"%Y-%m") AS trade_month '),
              'media_id',
              'media_name',
              DB::raw('if(is_paid=1, SUM(media_price),0) AS paid_prices '),
              DB::raw('if(is_paid=0, SUM(media_price),0) AS no_paid_prices '),
              'is_paid', 
              'created_at'         
             
            )
           ->groupBy('trade_month','media_name')
           ->orderBy('trade_month','desc')
           ->get();
         
           $rows =[];
           if($model->isNotEmpty()){
               $rows = $model->toArray();
           }
         
          
           $prices = $paid_prices = $no_paid_prices = $profits = 0;
           foreach ($rows as $key=>$items){

              //显示处理及汇总
              $rows[$key]['status'] = $items['is_paid'];
              $rows[$key]['is_paid'] = Base::dispayStyle('is_paid',$items['is_paid']);
               $paid_prices += $items['paid_prices'];
               $no_paid_prices += $items['no_paid_prices'];
           }
           $arrsum =['paid_prices'=>$paid_prices,'no_paid_prices'=>$no_paid_prices];
           $listview = view('admin.report.paid',compact('rows','url','arrsum'))->render();
           $content->row($listview);
      });
   }


   /**
    * 根据条件查询交易ids
    * @param array $data
    * @return array $ids
    */
   public function getTradeIds($data=[]){
       $ids =[];
       if(empty($data)){
           return $ids;
       }
       
       foreach (Trade::where($data)->get(['trade_id']) as $trade){
           $ids[] =  $trade->trade_id;
       }
       return $ids;
   }
   
  
    
}

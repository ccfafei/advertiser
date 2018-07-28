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


class PaidReportController extends Controller
{
   use ModelForm;
   
   //按时间，媒体名称,出款状态汇总，汇总时该条记录必须被审核
   public function getMediaReceived(Request $request ){
      return Admin::content(function (Content $content) use($request) {
          $content->header('媒体出款报表');
          $content->description('付款');
          $model = new Trade();
          $model = $model->where('is_check',1);
          
          //客户姓名
          if($request->has('media_name')){
              $media_name = $request->input('media_name');
              $model = $model->where('media_name','like','%'.$media_name.'%');
          }
          
          
          //注意时间判断，过滤临界值
          if( $request->has('start_day')){
             $start_day = strtotime($request->input('start_day'));
             $start_day >time() && $start_day = strtotime(' 00:00:00');
             $model = $model->where('trade_ts','>=',$start_day);
             
          }
         
          if( $request->has('end_day')){
              $end_day = strtotime($request->input('end_day'));
              $end_day > time() && $end_day = time();
              if(!empty($start_day) && $end_day <$start_day ){
                  $end_day = $start_day;
              }
              $model = $model->where('trade_ts','<=',$end_day);
          }
        

          
           //状态选择
          if($request->has('is_paid') && $request->input('is_paid')!='all'){
              $is_paid= $request->input('is_paid');
              $model = $model->where('is_paid',(int)$is_paid);
          }
        
          
          //查询
          $model = $model->select( 
              DB::raw('FROM_UNIXTIME(trade_ts,"%Y-%m-%d") AS trade_ts '),
              'media_id',
              'media_name',
              DB::raw('SUM(media_price) AS media_price '),
              'is_paid', 
              'created_at'         
             
            )
           ->groupBy('trade_ts','media_name','is_received')
           ->orderBy('trade_ts','desc')
           ->get();
         
           $rows =[];
           if($model->isNotEmpty()){
               $rows = $model->toArray();
           }
         
          
           $prices = $customer_prices = $media_prices = $profits = 0;
           foreach ($rows as $key=>$items){
              //查询当前时间段内相关回款状态的交易id
              $conditions =[
                  'media_id'=>$items['media_id'],
                  'trade_ts'=>strtotime($items['trade_ts']),
                  'is_paid'=>$items['is_paid'],
              ];
              $trade_arr = $this->getTradeIds($conditions);
              $rows[$key]['trade_ids'] = implode(',',$trade_arr);

              
              //显示处理及汇总
              $rows[$key]['status'] = $items['is_paid'];
              $rows[$key]['is_paid'] = Base::dispayStyle('is_paid',$items['is_paid']);
              $media_prices += $items['media_price'];//报价
              unset($conditions);
              unset($trade_arr);
           }
           $arrsum =['media_prices'=>$media_prices];
           $listview = view('admin.report.paid',compact('rows','url','arrsum'))->render();
           $content->row($listview);
      });
   }

   /**
    * 修改交易id状态
    * @param Request $request
    */
   public function paidUpdate(Request $request)
   {
      
       foreach (Trade::find($request->get('ids')) as $trade) {
           $trade->is_paid = $request->get('action');
           $trade->save();
       }
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

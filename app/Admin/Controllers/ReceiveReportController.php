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


class ReceiveReportController extends Controller
{
   use ModelForm;
   
   //回款,按时间，客户名称,回款状态汇总，汇总时该条记录必须被审核
   public function getCustomerReceived(Request $request ){
      return Admin::content(function (Content $content) use($request) {
          $content->header('客户回款报表');
          $content->description('收款');
          $model = new Trade();
          $model = $model->where('is_check',1);
          
          //客户姓名
          if($request->has('customer_name')){
              $customer_name = $request->input('customer_name');
              $model = $model->where('customer_name','like','%'.$customer_name.'%');
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
          if($request->has('is_received') && $request->input('is_received')!='all'){
              $is_received= $request->input('is_received');
              $model = $model->where('is_received',(int)$is_received);
          }
        
          
          //查询
          $model = $model->select( 
              DB::raw('FROM_UNIXTIME(trade_ts,"%Y-%m-%d") AS trade_ts '),
              'customer_id',
              'customer_name',
              DB::raw('SUM(customer_price) AS customer_price '),
              'is_received', 
              'created_at'         
             
            )
           ->groupBy('trade_ts','customer_name','is_received')
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
                  'customer_id'=>$items['customer_id'],
                  'trade_ts'=>strtotime($items['trade_ts']),
                  'is_received'=>$items['is_received'],
              ];
              $trade_arr = $this->getTradeIds($conditions);
              $rows[$key]['trade_ids'] = implode(',',$trade_arr);

              
              //显示处理及汇总
              $rows[$key]['status'] = $items['is_received'];
              $rows[$key]['is_received'] = Base::dispayStyle('is_received',$items['is_received']);
              $customer_prices += $items['customer_price'];//报价
              unset($conditions);
              unset($trade_arr);
           }
           $arrsum =['customer_prices'=>$customer_prices];
           $listview = view('admin.report.receive',compact('rows','url','arrsum'))->render();
           $content->row($listview);
      });
   }

   /**
    * 修改交易id状态
    * @param Request $request
    */
   public function receiveUpdate(Request $request)
   {
      
       foreach (Trade::find($request->get('ids')) as $trade) {
           $trade->is_received = $request->get('action');
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
   
   /**
    * 根据ids查询交易明细数据库
    * @param array $ids
    * @return array $trades
    */
   public function getTadeDetails(Request $request){
       $ids = $request->input('ids');
       $trades =[];
       if(empty($ids)){
           return response()->json(['status'=>0,'data'=>$trades]);
       }
       $trades = Trade::find($ids);
       if(collect($trades)->isNotEmpty()){
           $trades = $trades->toArray();
       }
       foreach ($trades as $key=>$items){
           $trades[$key]['trade_ts'] = date('Y-m-d',$items['trade_ts']);
           $trades[$key]['is_received'] =  Base::dispayStyle('is_received',$items['is_received']);
           $trades[$key]['is_paid'] = Base::dispayStyle('is_paid',$items['is_paid']);
           $trades[$key]['is_check'] = Base::dispayStyle('is_check',$items['is_check']);
       }
       return response()->json(['status'=>1,'data'=>$trades]);
   }
    
}

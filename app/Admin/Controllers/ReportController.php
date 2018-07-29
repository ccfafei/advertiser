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

class ReportController extends Controller
{
    use ModelForm;

    /**
     * 10天数据汇总报表,经过确认，已经回款和回款数
     */
    public function getDayReport()
    {
        $start_day = strtotime('-10 day 00:00:00');
        $end_day =  time();
        $arr = range($start_day, strtotime(' 00:00:00'), 86400);
        $responses=[];
        
       /*
        $responses['customer_price'] = Trade::select(DB::raw('FROM_UNIXTIME(trade_ts,"%Y-%m-%d") AS day '),
             DB::raw('SUM(customer_price) AS customer_price '), DB::raw('SUM(media_price) AS media_price '), 
            DB::raw('SUM(customer_price-media_price) AS profit '))->whereBetween('trade_ts', [
            $start_day,
            $end_day
        ])
            ->where('is_check', 1)
            ->where('is_received', 1)
            ->where('is_paid', 1)
            ->groupBy('day')
            ->get();
        */
        $arr1 = $this->getDaySum('customer_price','is_received',$start_day,$end_day);
        $arr2 = $this->getDaySum('media_price','is_paid',$start_day,$end_day);
        $responses = $arr1+$arr2;

        $newdata = [
            'customer_price' => 0,
            'media_price' => 0,
            'profit' => 0
        ];
        $result = [];
        $newresponse=[];
        if (collect($responses)->isNotEmpty()) {
            foreach ($responses as $k => $v) {
                $v['day'] = strtotime($v['day']);
                $newresponse[$v['day']] = $v;
            }
        }

        foreach ($arr as $items) {
           
            if (empty($newresponse[$items])) {
                $newdata['day'] = $items;
                $result[$items] = $newdata;
            } else { 
                $result[$items]['day'] =$items;
                $result[$items] ['customer_price']= empty($newresponse[$items]['customer_price'])?
                                0:$newresponse[$items]['customer_price'];
                $result[$items] ['media_price']= empty($newresponse[$items]['media_price'])?
                                0:$newresponse[$items]['media_price'];
                $result[$items]['profit'] =  $result[$items] ['customer_price']-$result[$items] ['media_price'];
            }
        }
        $result = array_values($result);
        
        return $result;
    }

    /**
     * 待办事务处理通知
     */
    public function getReportNotice()
    {
        $noCheck = Trade::where('is_check', 0)->orWhereNull('is_check')->count();
        $noReceived = Trade::where('is_received', 0)->orWhereNull('is_received')->sum('customer_price');
        $noPaid = Trade::where('is_paid',0)->orWhereNull('is_paid')->sum('media_price');
       $data =[
           'no_check'=>isset($noCheck)?$noCheck:0,
           'no_received'=>isset($noReceived)?$noReceived:0,
           'no_paid'=>isset($noPaid)?$noPaid:0,
       ];
       return $data;
   }
   
   public function getDaySum($field,$check,$start_day,$end_day){
       $responses = Trade::select(
           DB::raw('FROM_UNIXTIME(trade_ts,"%Y-%m-%d") AS day '),
           DB::raw("SUM({$field}) AS {$field} ")
       )->whereBetween('trade_ts', [
           $start_day,
           $end_day
       ])
       ->where('is_check', 1)
       ->where("{$check}", 1)
       ->groupBy('day')
       ->get();
       if(!empty($responses)){
           $responses = $responses->toArray();
       }else{
            $responses = [];
       }
       
       return $responses;
   }
 
    
}

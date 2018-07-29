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
        $end_day = strtotime(' +1 day 00:00:00');
        $arr = range($start_day, $end_day, 86400);
        $responses = Trade::select(DB::raw('FROM_UNIXTIME(trade_ts,"%Y-%m-%d") AS day '), DB::raw('SUM(customer_price) AS customer_price '), DB::raw('SUM(media_price) AS media_price '), DB::raw('SUM(customer_price-media_price) AS profit '))->whereBetween('trade_ts', [
            $start_day,
            $end_day
        ])
            ->where('is_check', 1)
            ->where('is_received', 1)
            ->where('is_paid', 1)
            ->groupBy('day')
            ->get();
        
        $newdata = [
            'customer_price' => 0,
            'media_price' => 0,
            'profit' => 0
        ];
        $result = [];
        if (collect($responses)->isNotEmpty()) {
            $responses = $responses->toArray();
            foreach ($responses as $k => $v) {
                $v['day'] = strtotime($v['day']);
                $responses[$k][$v['day']] = $v;
            }
        }
        
        foreach ($arr as $items) {
            if (empty($responses[$items])) {
                $newdata['day'] = $items;
                $result[$items] = $newdata;
            } else {
                $result[$items] = $responses[$items];
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
 
    
}

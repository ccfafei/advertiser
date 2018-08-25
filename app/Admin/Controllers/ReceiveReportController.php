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

class ReceiveReportController extends Controller
{
    use ModelForm;

    //回款,按时间，客户名称,回款状态汇总，汇总时该条记录必须被审核
    public function getCustomerReceived(Request $request)
    {
        return Admin::content(function (Content $content) use ($request) {
            Permission::check('report.view');
            $content->header('客户回款报表');
            $content->description('收款');
            $model = new Trade();
            $model = $model->where('is_check', 1);

            //客户姓名
            if ($request->has('customer_name')) {
                $customer_name = $request->input('customer_name');
                $model = $model->where('customer_name', 'like', '%' . $customer_name . '%');
            }
            if ($request->has('month')) {
                $month_start = $request->input('month');
                $model = $model->where( DB::raw(' FROM_UNIXTIME(trade_ts,"%Y-%m")'), $month_start);
            }

            //状态选择
            if ($request->has('is_received') && $request->input('is_received') != 'all') {
                $is_received = $request->input('is_received');
                $model = $model->where('is_received', (int)$is_received);
            }


            //查询
            $model = $model->select(
                DB::raw(' FROM_UNIXTIME(trade_ts,"%Y-%m") AS trade_month '),
                'customer_id',
                'customer_name',
                DB::raw('if(is_received=1, SUM(customer_price),0) AS received_prices '),
                DB::raw('if(is_received=0, SUM(customer_price),0) AS no_received_prices '),
                'is_received',
                'leader'

            )
                ->groupBy('trade_month', 'customer_name')
                ->orderBy('trade_ts', 'desc')
                ->get();

            $rows = [];
            if ($model->isNotEmpty()) {
                $rows = $model->toArray();
            }


            $prices = $received_prices = $no_received_prices = $profits = 0;
            foreach ($rows as $key => $items) {

                //显示处理及汇总
                $rows[$key]['status'] = $items['is_received'];
                $rows[$key]['is_received'] = Base::dispayStyle('is_received', $items['is_received']);
                $received_prices += $items['received_prices'];//报价
                $no_received_prices += $items['no_received_prices'];//报价
            }
            $arrsum = ['received_prices' => $received_prices, 'no_received_prices' => $no_received_prices];
            $listview = view('admin.report.receive', compact('rows', 'url', 'arrsum'))->render();
            $content->row($listview);
        });
    }


    /**
     * 根据条件查询交易ids
     * @param array $data
     * @return array $ids
     */
    public function getTradeIds($data = [])
    {
        $ids = [];
        if (empty($data)) {
            return $ids;
        }

        foreach (Trade::where($data)->get(['trade_id']) as $trade) {
            $ids[] = $trade->trade_id;
        }
        return $ids;
    }

    /**
     * 根据ids查询交易明细数据库
     * @param array $ids
     * @return array $trades
     */
    public function getTadeDetails(Request $request)
    {
        $ids = $request->input('ids');
        $trades = [];
        if (empty($ids)) {
            return response()->json(['status' => 0, 'data' => $trades]);
        }
        $trades = Trade::find($ids);

        if (collect($trades)->isNotEmpty()) {
            $trades = $trades->toArray();
        } else {
            return response()->json(['status' => 0, 'data' => $trades]);

        }
        foreach ($trades as $key => $items) {
            $trades[$key]['trade_ts'] = $items['trade_ts'];
            $trades[$key]['is_received'] = Base::dispayStyle('is_received', $items['is_received']);
            $trades[$key]['is_paid'] = Base::dispayStyle('is_paid', $items['is_paid']);
            $trades[$key]['is_check'] = Base::dispayStyle('is_check', $items['is_check']);
        }
        // 1;
        return response()->json(['status' => 1, 'data' => $trades]);
    }

}

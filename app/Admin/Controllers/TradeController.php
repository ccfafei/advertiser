<?php
namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use App\Admin\Controllers\Base;
use App\Models\Trade;
use Illuminate\Support\MessageBag;
use App\Admin\Extensions\Tools\TradeCheck;
use App\Admin\Extensions\Tools\TradeSearch;
use Illuminate\Support\Facades\Input;
use Encore\Admin\Auth\Permission;

class TradeController extends Controller
{
    use ModelForm;
    private $trade_header =[
                '序号',
                '日期',
                '客户名称',
                '媒体名称',
                '稿件标题',
                '链接',
                '字数',
                '单价',
                '报价',
                '媒体款',
                '利润',
                '是否回款',
                '是否出款',
                '审核',
                '负责人',
            ];

    /**
     * Index interface.
     * 交易列表
     * 
     * @return Content
     */
    public function index(Request $request)
    {
        return Admin::content(function (Content $content) use($request)
        {
            
            $content->header('业务流量');
            $content->description('列表');
            $headers = $this->trade_header;
            $rows = [];
            $where = [];
            $mode = new Trade();
            $request->has('customer_name') &&!empty($request->input('customer_name'))&&
            $mode = $mode->where('customer_name', 'like', '%' . $request->input('customer_name') . '%');

            $request->has('media_name') && !empty($request->input('media_name'))&&
            $mode = $mode->where('media_name', 'like', '%' . $request->input('media_name') . '%');

            $request->has('contribution') &&!empty($request->input('contribution'))&&
            $mode = $mode->where('contribution', 'like', '%' . $request->input('contribution') . '%');

            $request->has('leader') &&!empty($request->input('leader'))&&
            $mode = $mode->where('leader', 'like', '%' . $request->input('leader') . '%');

            $inputs = $request->only([
                'is_received',
                'is_paid',
                'is_check'
            ]);
            foreach ($inputs as $k => $v) {
                if (! empty($v))
                    $where[$k] = $v;
            }
            $start_ts = $request->input('start_day');
            $end_ts = $request->input('end_day');
            $search_start_day = $start_ts ? strtotime($start_ts) : strtotime('-30 day 00:00:00');
            $search_end_day = $end_ts ? strtotime($end_ts) : time();
            if ($search_end_day < $search_start_day && $search_start_day <= time()) {
                $search_end_day = $search_start_day;
            }
            $inputs['start_day'] = date('Y-m-d', $search_start_day);
            $inputs['end_day'] = date('Y-m-d', $search_end_day);
            
            $mode = $mode->whereBetween('trade_ts', [
                $search_start_day,
                $search_end_day
            ]);
            ! empty($where) && $mode = $mode->where($where);
            // 只能看自己的业务
            if (! Admin::user()->isAdministrator()) {
                $mode = $mode->where('leader', Admin::user()->name);
            }
            
            $results = $mode->get();
            if ($results->isNotEmpty()) {
                $rows = $results->toArray();
            }
            $prices = $customer_prices = $media_prices = $profits = 0;
            $checks = config('trade.is_check');
            foreach ($rows as $key => $items) {
                $rows[$key]['trade_ts'] = $items['trade_ts'];
                $rows[$key]['is_received'] = Base::dispayStyle('is_received', $items['is_received']);
                $rows[$key]['is_paid'] = Base::dispayStyle('is_paid', $items['is_paid']);
                $rows[$key]['is_check'] = Base::dispayStyle('is_check', $items['is_check']);
                $prices += $items['price']; // 报价合计
                $customer_prices += $items['customer_price']; // 报价
                $media_prices += $items['media_price']; // 媒体款
                $profits += $items['profit']; // 利润
            }
            $arrsum = [
                'prices' => $prices,
                'customer_prices' => $customer_prices,
                'media_prices' => $media_prices,
                'profits' => $profits
            ];
            $serach=['start_day','end_day','customer_name','media_name','contribution','leader','is_received','is_paid','is_check'];
            $search_arr =Base::getSearchs($request,$serach);
            $exporturl = $this->grid()->exportUrl('all');
            $url = $exporturl;
            $listview = view('admin.trade.list', compact('rows', 'headers', 'checks', 'url', 'inputs', 'arrsum','search_arr'))->render();
            $content->row($listview);
        });
    }

    /**
     * Edit interface.
     *
     * @param
     *            $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use($id)
        {
            
            $content->header('业务流量 ');
            $content->description('编辑');
            Permission::check('trade.edit');
            
            $content->body($this->form()
                ->edit($id));
        });
    }

    /**
     * Edit interface.
     *
     * @param
     *            $id
     * @return Content
     */
    public function updatetrade(Request $request)
    {
        $data = $request->input();
        //dd($data);
        $trade_id = $data['trade_id'];
        $data['trade_ts'] = strtotime($data['trade_ts']);
        unset($data['_token']);
        unset($data['_method']);
        unset($data['_previous_']);
        unset($data['\\']);
        //var_dump($data);die;
        $result = Trade::where('trade_id',$trade_id)->update($data);
        if($result){
            $success = new MessageBag([
                'title' => '更新成功!'
            ]);
            return redirect(url('admin/trade/check/'.$trade_id.'/edit'))->with(compact('success'));

        }else{
            $error  = new MessageBag([
                'title' => '更新失败!'
            ]);
            return redirect(url('admin/trade/check/'.$trade_id.'/edit'))->with(compact('error'));
        }


    }


    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content)
        {
            
            $content->header('业务流量');
            $content->description('人工录入');
            
            $content->body($this->form());
        });
    }

    public function check(Request $request)
    {
        return Admin::content(function (Content $content) use($request)
        {
            $content->header('业务审核及修改');
            $content->description('审核');
            Permission::check('trade.edit');
            Permission::check('trade.check');
            $headers =$this->trade_header;
            array_unshift($headers,'选择');
            array_push($headers,'操作');
            $rows = [];
            $where = [];
            $mode = new Trade();
            $request->has('customer_name') &&!empty($request->input('customer_name'))&&
            $mode = $mode->where('customer_name', 'like', '%' . $request->input('customer_name') . '%');
            
            $request->has('media_name') && !empty($request->input('media_name'))&&
            $mode = $mode->where('media_name', 'like', '%' . $request->input('media_name') . '%');
            
            $request->has('contribution') &&!empty($request->input('contribution'))&&
            $mode = $mode->where('contribution', 'like', '%' . $request->input('contribution') . '%');

            $request->has('leader') &&!empty($request->input('leader'))&&
            $mode = $mode->where('leader', 'like', '%' . $request->input('leader') . '%');


            $inputs = $request->only([
                'is_received',
                'is_paid',
                'is_check'
            ]);
            foreach ($inputs as $k => $v) {
                if (! empty($v))
                    $where[$k] = $v;
            }
            $start_ts = $request->input('start_day');
            $end_ts = $request->input('end_day');
            $search_start_day = $start_ts ? strtotime($start_ts) : strtotime('-1 day 00:00:00');
            $search_end_day = $end_ts ? strtotime($end_ts) : time();
            if ($search_end_day < $search_start_day && $search_start_day <= time()) {
                $search_end_day = $search_start_day;
            }
            $inputs['start_day'] = date('Y-m-d', $search_start_day);
            $inputs['end_day'] = date('Y-m-d', $search_end_day);
            
            $mode = $mode->whereBetween('trade_ts', [
                $search_start_day,
                $search_end_day
            ]);
            ! empty($where) && $mode = $mode->where($where);

            $rows = $mode->orderBy('id','desc')->paginate(config('trade')['pageSize']);
            $prices = $customer_prices = $media_prices = $profits = 0;
            $checks = config('trade.is_check');
            if(collect($rows)->isNotEmpty()){
                foreach($rows -> items()  as &$item){
                    $item['trade_ts'] = $item['trade_ts'];
                    $item['is_received'] = Base::dispayStyle('is_received', $item['is_received']);
                    $item['is_paid'] = Base::dispayStyle('is_paid', $item['is_paid']);
                    $item['is_check'] = Base::dispayStyle('is_check', $item['is_check']);
                    $prices += $item['price']; // 报价合计
                    $customer_prices += $item['customer_price']; // 报价
                    $media_prices += $item['media_price']; // 媒体款
                    $profits += $item['profit']; // 利润
                }
            }
            $arrsum = [
                'prices' => $prices,
                'customer_prices' => $customer_prices,
                'media_prices' => $media_prices,
                'profits' => $profits
            ];
            $serach=['start_day','end_day','customer_name','media_name','contribution','leader','is_received','is_paid','is_check'];
            $search_arr =Base::getSearchs($request,$serach);
            $listview = view('admin.trade.check', compact('rows', 'headers', 'checks', 'url', 'inputs', 'arrsum','search_arr'))->render();
            $content->row($listview);
        });
    }

    /**
     * 审核数据
     * @param Request $request
     * @return multitype:number string multitype:
     */
    protected function checkUpdate(Request $request)
    {
        return $this->optionsCheck($request,'is_check');
    }

    
    /**
     * 修改出款id状态
     * @param Request $request
     */
    public function paidUpdate(Request $request)
    {
        return $this->optionsCheck($request,'is_paid');
    }
    
    /**
     * 修改回款id状态
     * @param Request $request
     */
    protected function receiveUpdate(Request $request)
    {
        return $this->optionsCheck($request,'is_received');

    }
 protected function checkDestory(Request $request){
     if (! Permission::check('trade.check')) {
         return $reponses = [
             'status' => 1,
             'msg' => '无权访问!',
             'data' => []
         ];
     }
     $trade_id = $request->input('trade_id');
     $trade_id = explode(',',$trade_id);
     if (empty($trade_id)){
         return $reponses = [
             'status' => 1,
             'msg' => '参数不能为空!',
             'data' => []
         ];
     }
     try {
         Trade::destroy($trade_id);
         return $reponses = [
             'status' => 0,
             'msg' => '删除成功!',
             'data' => []
         ];
     }catch (\Exception $e){
         return $reponses = [
             'status' => 1,
             'msg' => '删除失败!',
             'data' => []
         ];
     }
 }


    /**
     * 更新数据公用方法
     * @param Request $request
     * @param unknown $field
     * @return multitype:number string multitype:
     */
    public function optionsCheck(Request $request,$field){
        if (! Permission::check('trade.check')) {
            return $reponses = [
                'status' => 1,
                'msg' => '无权访问!',
                'data' => []
            ];
        }
        $params = $request->get('ids');
        $ids = explode(',',$params);
        //return $ids;
        $action = $request->get('action');
        if (empty($ids)) {
            return $reponses = [
                'status' => 1,
                'msg' => '您未选数据!',
                'data' => []
            ];
        }
        
        $ids = is_array($ids) ? $ids : [
            $ids
        ];
        foreach (Trade::find($ids) as $trade) {
            $trade->$field = $action;
            try {
                $trade->save();
            } catch (\Exception $e) {
                return $reponses = [
                    'status' => 1,
                    'msg' => '更数据数据失败!',
                    'data' => []
                ];
            }
        }
        
        return $reponses = [
            'status' => 0,
            'msg' => '更新数据成功!',
            'data' => []
        ];
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Trade::class, function (Grid $grid) {
        
            //关闭过滤
            $grid->disableFilter();
            $grid->disableCreation();
            $grid->tools->disableRefreshButton();

            //修改权限
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                if (!Admin::user()->can('trade.edit')) {
                    $actions->disableEdit();
                }
            });
            
            //加自定义审核功能 
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                    if (Admin::user()->can('trade.edit')) {
                        $batch->add('审核通过', new TradeCheck(1));
                        $batch->add('审核不通过', new TradeCheck(2));
                    }
                
                });
              });
            
            //搜索功能 
            $grid->tools(function ($tools) {
                $tools->append(new TradeSearch());
            });
       
            $checked = Input::get('is_check',0);
            if($checked !='all'){
                $is_check = intval($checked);
                $grid->model()->where('is_check',$is_check);
              
            }else{
                $grid->model();
            }
     
            //只能看自己的业务
            if(!Admin::user()->isAdministrator()){
                $grid->model()->where('leader', Admin::user()->name);
            }
            
           // $grid->trade_id('ID')->sortable();
            
            $grid->trade_ts('交易时间')->display(function ($time) {
                if(is_int($time)){
                    $time = date('Y-m-d',$time);
                }
                return $time;
            })->sortable();
    
            $grid->customer_name('客户名称')->sortable();
    
            $grid->media_name('媒体名称')->sortable();
            $grid->contribution('稿件名称')->sortable();
            $grid->contribution('链接')->display(function ($project) {
                $link = preg_match('/^http(s)?:\\/\\/.+/',$project)?$project:'http://'.$project;
                return '<a href="'.$link.'" target="_blank">查看</a>';
                
            });
            $grid->words('字数');
            $grid->price('单价');
            $grid->customer_price('报价')->sortable();
            $grid->media_price('媒体款')->sortable();
            $grid->profit('媒体款')->sortable();
            $grid->is_received('是否回款')->display(function ($is_received) {
                return Base::dispayStyle('is_received', (int)$is_received);
            })->sortable();
            
            $grid->is_paid('是否出款')->display(function ($is_paid) {
                return Base::dispayStyle('is_paid', (int)$is_paid);
            })->sortable();
            
            $grid->is_check('审核')->display(function ($is_check) {
              return Base::dispayStyle('is_check', (int)$is_check);
            })->sortable();
             
          
        });
    }
    
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Trade::class, function (Form $form) {
    
            $form->hidden('trade_id','交易ID');
            $form->text('customer_name','客户名称')->rules('required|min:1',['不能为空']);
            $form->text('media_name','媒体名称')->rules('required|min:1',['不能为空']);
            $form->text('contribution','稿件名称')->rules('required|min:1',['不能为空']);
            $form->text('project','项目链接')->rules('required|min:1',['不能为空']);;
            $form->text('words','字数');
            $form->text('price','单价');
            $form->text('customer_price','报价');
            $form->text('media_price','媒体款');  
            $form->text('profit','利润');
            $form->date('trade_ts','交易时间')->format('YYYY-MM-DD')->rules('required|min:1',['不能为空']);;
            if(!Admin::user()->isAdministrator()){
                $form->hidden('leader','负责人')->default(function($user){
                    return $user= Admin::user()->name;
                });
            }else{
                $form->text('leader','负责人');
            }                   
            $form->textarea('remark','备注');
            $form->hidden('created_at', 'Created At');
            $form->hidden('updated_at', 'Updated At');
            $form->hidden('customer_id','客户id');
           // $form->hidden('media_id','媒体id');
            
            //保存前检查
            $form->saving(function (Form $form) {
                   $data =[
                       'trade_ts'=>strtotime($form->trade_ts),
                       'customer_name'=>$form->customer_name,
                       'media_name'=>$form->media_name,
                       'contribution'=>$form->contribution,

                   ];
                  // dd($data);

                    if(empty($form->trade_id)){
                        $reslut = Trade::where($data)->get();
                        //dd(collect($reslut)->isNotEmpty());
                        if(collect($reslut)->isNotEmpty()){
                            $error = new MessageBag([
                                    'title'   => '出错啦:',
                                    'message' => '该记录已经录入过了!',
                            ]);
                            return back()->with(compact('error'));
                        }
                    }

                
//                $customers= Base::getCustomer($form->customer_name);
//                if(!$customers){
//                 $error = new MessageBag([
//                        'title'   => '出错啦:',
//                        'message' => '客户不存在,请先录入客户资料!',
//                    ]);
//                    return back()->with(compact('error'));
//                }
              

            });
          
          //save...
    });
}


}


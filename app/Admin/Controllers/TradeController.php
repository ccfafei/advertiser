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


class TradeController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *Customer
     * @return Content
     */
    public function index(Request $request)
    {

        return Admin::content(function (Content $content) use($request) {
    
            $content->header('业务流量');
            $content->description('列表'); 
            $headers = ['序号','日期','客户名称','媒体名称','稿件标题','字数','单价','报价','媒体款','利润','是否回款',	'是否出款','是否审核'];
            $rows =[];
            $where =[];
            if($request->has('customer_name')){
                $search_customer_name =$request->input('customer_name');
                !empty($search_customer_name)&&$where['customer_name'] = $search_customer_name;
            }
            if($request->has('media_name')){
                $search_media_name =$request->input('media_name');
                !empty($search_media_name)&&$where['media_name'] = $search_media_name;
            }
            if($request->has('contribution')){
                $search_contribution =$request->input('contribution');
                !empty($search_contribution)&&$where['contribution'] = $search_contribution;
            }
            
            if($request->has('contribution')){
                $search_is_received=$request->input('is_received');
                !empty($search_is_received)&&$where['is_received'] = $search_is_received;
            }
            if($request->has('is_paid')){
                $search_is_paid=$request->input('is_paid');
                !empty($search_is_paid)&&$where['is_paid'] = $search_is_paid;
            }
            if($request->has('is_paid')){
                $search_is_paid=$request->input('is_paid');
                !empty($search_is_paid)&&$where['is_paid'] = $search_is_paid;
            }
            
            if($request->has('is_check')){
                $search_is_check=$request->input('is_check');
                !empty($search_is_check)&&$where['is_check'] = $search_is_check;
            }
            $search_start_day= empty($request->input('start_day'))?
                                strtotime('-90 day 00:00:00'):strtotime($request->input('start_day'));
            $search_end_day= empty($request->input('end_day'))? time():strtotime($request->input('end_day'));
            if($search_end_day < $search_start_day&&$search_start_day<=time()){
                $search_end_day = $search_start_day;
            }
            if(!empty($where)){
                $results = Trade::whereBetween('trade_ts',[$search_start_day,$search_end_day])->where($where)->get();
            }else{
                $results = Trade::whereBetween('trade_ts',[$search_start_day,$search_end_day])->get();
            }
            if($results->isNotEmpty()){
                $rows = $results->toArray();
            }
            $receiveds = config('trade.is_received');
            $paids = config('trade.is_paid');
            $checks = config('trade.is_check');
            foreach ($rows as $key=>$items){
                $rows[$key]['is_received'] = $receiveds[(int)$items['is_received']];
                $rows[$key]['is_paid'] = $paids[(int)$items['is_paid']];
                $rows[$key]['is_check'] = $checks[(int)$items['is_check']];
            }
            $exporturl = $this->grid()->exportUrl('all');
            $url = $exporturl;
            $listview = view('admin.trade.list',compact('rows','headers','receiveds','paids','checks','url'))->render();
            $content->row($listview);
        });
    }
    
    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
    
            $content->header('业务流量 ');
            $content->description('编辑');
    
            $content->body($this->form()->edit($id));
        });
    }
    
    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
    
            $content->header('业务流量');
            $content->description('人工录入');
    
            $content->body($this->form());
        });
    }
    
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Trade::class, function (Grid $grid) {
    
            $grid->disableRowSelector();
            $grid->actions(function ($actions) {
                $actions->disableDelete();    
                if (!Admin::user()->can('trade.edit')) {
                    $actions->disableEdit();
                }
            });
           // $grid->trade_id('ID')->sortable();
            $grid->trade_ts('交易时间')->display(function ($time) {
                return date('Y-m-d',strtotime($time));
            })->sortable();
    
            $grid->customer_name('客户名称')->sortable();
    
            $grid->media_name('媒体名称')->sortable();
            $grid->contribution('稿件名称')->sortable();
            $grid->words('字数');
            $grid->price('单价');
            $grid->customer_price('报价')->sortable();
            $grid->media_price('媒体款')->sortable();
            $grid->profit('媒体款')->sortable();
            $grid->is_received('是否回款')->display(function ($is_received) {
                $configs = config('trade.is_received');
                $is_received = (int)$is_received;
                return $configs[$is_received];

            })->sortable();
            
            $grid->is_paid('是否出款')->display(function ($is_paid) {
                $configs = config('trade.is_paid');
                $is_paid = (int)$is_paid;
                return $configs[$is_paid];
            })->sortable();
            
            $grid->is_check('审核')->display(function ($is_check) {
               $configs = config('trade.is_check');
                $is_check = (int)$is_check;
                return $configs[$is_check];
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
            $form->text('customer_name','客户名称');          
            $form->text('media_name','媒体名称');           
            $form->text('contribution','稿件名称');
            $form->text('words','字数');
            $form->text('price','单价');
            $form->text('customer_price','报价');
            $form->text('media_price','媒体款');  
            $form->text('profit','利润');
            $form->date('trade_ts','交易时间')->format("YYYY-MM-DD");                    
            $form->textarea('remark','备注');
            $form->hidden('created_at', 'Created At');
            $form->hidden('updated_at', 'Updated At');
            $form->hidden('customer_id','客户id');
            $form->hidden('media_id','媒体id');
            //保存前检查
            $form->saving(function (Form $form) {
                
                $customers= Base::getCustomer($form->customer_name);
                if(!$customers){
                 $error = new MessageBag([
                        'title'   => '出错啦:',
                        'message' => '客户不存在,请先录入客户资料!',
                    ]);                    
                    return back()->with(compact('error'));
                }
              
                
                $medias = Base::getMedia($form->media_name);
                if(!$medias){
                    $error = new MessageBag([
                        'title'   => '出错啦:',
                        'message' => '该媒体不存在,请先录入媒体资料!',
                    ]);
                    return back()->with(compact('error'));
                }
            });
          
          //save...
    });
}


}


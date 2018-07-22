<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Box;
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
    public function index()
    {
        return Admin::content(function (Content $content) {
    
            $content->header('业务流量');
            $content->description('列表');           
            $content->body($this->grid());
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
                return $is_received ? '是' : '否';
            })->sortable();
            
            $grid->is_paid('是否出款')->display(function ($is_paid) {
                return $is_paid ? '是' : '否';
            })->sortable();
            
            $grid->is_check('审核')->display(function ($is_paid) {
                switch ($is_paid){
                    case 0:
                        $checked = "未审核";
                        break;
                    case 1:
                        $checked = "通过";
                        break;
                    case 2:
                        $checked = "不通过";
                        break;
                    default:
                        $checked = "未审核";    
                }
                
                return $checked;
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


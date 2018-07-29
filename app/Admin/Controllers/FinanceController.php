<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Finance;
use Encore\Admin\Auth\Permission;
class FinanceController extends Controller
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

            $content->header('财务报表');
            $content->description('明细');

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
            Permission::check('finance.all');
            $content->header('财务报表');
            $content->description('修改');

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

            $content->header('账务记录');
            $content->description('录入');
            Permission::check('finance.all');

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
        return Admin::grid(Finance::class, function (Grid $grid) {
            
            $grid->disableRowSelector();
            $grid->actions(function ($actions) {
                $actions->disableDelete();

            });
           // $grid->id('记录ID')->sortable();
            $grid->pay_ts('日期')->display(function ($time) {
                    return date('Y-m-d',strtotime($time));
            })->sortable();
            $grid->project('项目')->sortable();
            $grid->money('金额')->sortable();
            $grid->type('进款/出款')->display(function ($type) {                 
                switch ($type){
                    case 1:
                        $type_name = '进款';
                        break;
                    case 2:
                        $type_name = '出款';
                        break;
                    default:
                        $type_name = '其它';
            
                }
                return $type_name;
            })->sortable();
            $grid->bank_account('账号');
            $grid->bank_name('账号姓名');
            $grid->company_name('公司名称');         
            $grid->remark('备注');
           
        });
        
          
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Finance::class, function (Form $form) {

            $form->hidden('id','ID');
            $form->date('pay_ts','日期')->format("YYYY-MM-DD");
            $form->select('type','类型')->options(['1'=>'进款','2'=>'出款','3'=>'其它']);
            $form->divide();
            $form->text('project','项目');
            $form->text('money','金额');
            $form->text('bank_account','账号');
            $form->text('bank_name','账号姓名');
            $form->text('company_name','公司名称');
            $form->textarea('remark','备注');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}

<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Customer;

class CustomerController extends Controller
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

            $content->header('用户');
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

            $content->header('header');
            $content->description('description');

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

            $content->header('客户');
            $content->description('新建');

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
        return Admin::grid(Customer::class, function (Grid $grid) {
            
            $grid->disableRowSelector();
            $grid->actions(function ($actions) {
                $actions->disableDelete();

            });
            $grid->customer_id('客户ID')->sortable();
            $grid->develop_ts('开发时间')->display(function ($time) {
                    return date('Y-m-d',strtotime($time));
            })->sortable();
            
            $grid->company('公司名称')->sortable();
                      
            $grid->qq('联系人')->sortable();
            $grid->phone('电话')->sortable();
            $grid->project('项目')->sortable();
            $grid->is_cooperate('是否合作')->display(function ($is_cooperate) {
                    return $is_cooperate ? '是' : '否';
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
        return Admin::form(Customer::class, function (Form $form) {

            $form->hidden('customer_id','客户ID');
            $form->tab('基本信息', function ($form) {
               
                $form->text('company','公司名称');
                $form->text('name','联系人');
                $form->mobile('phone','电话');
                $form->text('qq','微信/QQ');  
                $form->date('develop_ts','开发时间')->format("YYYY-MM-DD");
            
            })->tab('其它信息', function ($form) {
                $form->text('project','项目');       
                $form->radio('is_cooperate','是否合作')->options(['1' => '是', '0'=> '否'])->default('1');
                $form->textarea('remark','备注')->rows(10);
                $form->radio('status','启用/禁用')->options(['1' => '启用', '0'=> '禁用'])->default('1');
            
            });
            
            
         
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}

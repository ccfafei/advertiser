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

            $content->header('客户资料');
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

            $content->header('客户资料');
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

            $content->header('客户资料');
            $content->description('录入');

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
            $grid->project('项目')->display(function ($project) {
                $link = preg_match('/^http(s)?:\\/\\/.+/',$project)?$project:'http://'.$project;
                return '<a href="'.$link.'" target="_blank">查看</a>';
            });
            $grid->is_cooperate('是否合作')->display(function ($is_cooperate) {
                    return $is_cooperate ? '是' : '否';
            })->sortable();
            if(!Admin::user()->isAdministrator()){
                $grid->model()->where('leader',Admin::user()->username);
            }else{
                $grid->leader('负责人');
            }
            
            
            $grid->filter(function($filter){          
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->like('company', '客户姓名');
                $filter->between('develop_ts', '开发时间')->datetime();
                $filter->like('name', '联系人');
                $filter->equal('phone', '电话');
                $filter->like('qq', 'qq/微信');
                $filter->equal('project', '项目');
            
            });
           
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
                if(!Admin::user()->isAdministrator()){
                    $form->hidden('leader','负责人')->default(function($user){
                        return $user= Admin::user()->username;
                    });
                }else{
                    $form->text('leader','负责人');
                }
               
            
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

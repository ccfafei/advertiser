<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\MediaChannel;

class ChannelController extends Controller
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

            $content->header('频道');
            $content->description('创建');

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
        return Admin::grid(MediaChannel::class, function (Grid $grid) {
            
            $grid->disableRowSelector();
            $grid->channel_id('频道ID')->sortable();              
            $grid->channel_name('频道名称')->sortable();                      
            $grid->remark('备注');
            $grid->filter(function($filter){
                // 在这里添加字段过滤器
                $filter->disableIdFilter();
                $filter->like('channel_name', '频道名称');
                 
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
        return Admin::form(MediaChannel::class, function (Form $form) {
            $form->display('channel_id','频道ID');
            $form->text('channel_name','频道名称');
            $form->text('remark','备注');
        });
    }
}

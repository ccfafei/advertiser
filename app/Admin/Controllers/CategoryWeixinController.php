<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\WeixinCategory;

class CategoryWeixinController extends Controller
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
        
            $content->header('微信行业分类');
            $content->description('信息');
        
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
    
            $content->header('微信分类');
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
    
            $content->header('微信分类');
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
        return Admin::grid(WeixinCategory::class, function (Grid $grid) {
    
            $grid->disableRowSelector();
            $grid->category_id('分类ID')->sortable();
            $grid->category_name('分类名称')->sortable();
            $grid->remark('备注');
            
            $grid->filter(function($filter){
                // 在这里添加字段过滤器
                $filter->disableIdFilter();
                $filter->like('category_name', '分类名称');

            
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
        return Admin::form(WeixinCategory::class, function (Form $form) {
            $form->display('category_id','分类ID');
            $form->text('category_name','分类名称');
            $form->text('remark','备注');
        });
    }
}

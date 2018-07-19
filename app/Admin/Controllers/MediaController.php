<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Controllers\Base;
use App\Models\Media;


class MediaController extends Controller
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
    
            $content->header('媒体信息');
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
    
            $content->header('媒体信息');
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
    
            $content->header('媒体信息');
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
        return Admin::grid(Media::class, function (Grid $grid) {
    
            $grid->disableRowSelector();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            
            });
            $leaders = Base::getLeader(); 
            $channels = Base::getChannel(); 
            $categorys = Base::getCategory();
            $grid->media_id('媒体ID')->sortable();
            $grid->created_at('日期')->display(function($ts){
                return date('Y-m-d',strtotime($ts));
            })->sortable();
            $grid->media_name('媒体名称')->sortable();
            
            $grid->leader('负责人')->display(function($id) use($leaders){
                $name ='';
                if($leaders){
                    $name =$leaders[$id];
                }              
                return $name;
            })->sortable();
            
            $grid->category('媒体分类')->display(function($id) use($categorys){
                $name ='';
                if($categorys){
                    $name =$categorys[$id];
                }              
                return $name;
            })->sortable();
            $grid->channel('频道')->display(function($id) use($channels){
                $name ='';
                if($channels){
                    $name =$channels[$id];
                }              
                return $name;
            })->sortable();
            $grid->price('单价')->sortable();
            $grid->collection('收录');
            $grid->cases('案例');            
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
        return Admin::form(Media::class, function (Form $form) {
         
            $form->hidden('media_id','媒体ID');
            $form->text('media_name','媒体名称');
            $form->select('leader','负责人')->options(Base::getLeader());
            $form->select('category','媒体分类')->options(Base::getCategory());
            $form->select('channel','频道')->options(Base::getChannel());
            $form->number('price','单价');
            $form->text('collection','收录');
            $form->text('cases','案例');
            $form->textarea('remark','备注');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
    
 
    
   
}

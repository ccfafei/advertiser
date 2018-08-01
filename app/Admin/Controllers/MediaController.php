<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Controllers\Base;
use App\Models\Media;
use Illuminate\Support\Facades\DB;


class MediaController extends Controller
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
    
            $content->header('网络媒体');
            $content->description('列表'); 
            $headers = ['开发日期','媒体名称','媒体分类','频道','单价','收录','案例','负责人','操作'];
          
            //获取各个分类
            $category=Base::getCategory();
            $channel = Base::getChannel();
            $leader = Base::getLeader();
            
            //搜索结果
            $rows =[];
            $arrsum =[];
            $mode= new Media(); 
           
            $start_ts = $request->input('start_day');
            $end_ts = $request->input('end_day');
            $search_start_day= $start_ts?strtotime($start_ts):strtotime('-30 day 00:00:00');
            $search_end_day= $end_ts?strtotime($end_ts):time();
            if($search_end_day < $search_start_day&&$search_start_day<=time()){
                $search_end_day = $search_start_day;
            } 
            $mode = $mode->where(DB::RAW('UNIX_TIMESTAMP(media_ts)'),'>=',$search_start_day);
           
            $mode = $mode->where(DB::RAW('UNIX_TIMESTAMP(media_ts)'),'<=',$search_end_day);
            
            $request->has('media_name')&&
            $mode = $mode->where('media_name','like','%'.$request->input('media_name').'%');

           
            $request->has('category')&&$request->input('category')!='all'&&
            $mode = $mode->where('category',$request->input('category'));
     
            $request->has('channel')&&$request->input('channel')!='all'&&
            $mode = $mode->where('channel',$request->input('channel'));
            
            $request->has('leader')&&$request->input('leader')!='all'&&
            $mode = $mode->where('leader',$request->input('leader'));
            
            $request->has('price')&&!empty($request->input('price'))&&
            $mode = $mode->where('price',trim($request->input('price')));
            $rows = $mode->get();
            if(collect($rows)->isNotEmpty()){
                $rows=$rows->toArray();
                
            }
            
           $exporturl = $this->grid()->exportUrl('all');
            $listview = view('admin.media.list',
                compact('rows','headers','arrsum','category','channel','leader'))
            ->render();
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

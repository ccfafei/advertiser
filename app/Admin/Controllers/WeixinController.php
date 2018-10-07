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
use App\Models\Weixin;
use Illuminate\Support\Facades\DB;


class WeixinController extends Controller
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
    
            $content->header('微信媒体');
            $content->description('列表'); 
            $headers = ['开发日期','微信名称','行业分类','ID','粉丝数','头条','次条','第三条','预估阅读数','案例','负责人','备注','操作'];
          
            //获取各个分类
            $category=Base::getweixinCategory();
         
            $leader = Base::getweixinLeader();
            
            //搜索结果
            $rows =[];
            $arrsum =[];
            $mode= new weixin(); 
           
            $start_ts = $request->input('start_day');
            $end_ts = $request->input('end_day');
            $search_start_day= $start_ts?strtotime($start_ts):strtotime('2000-01-01 00:00:00');
            $search_end_day= $end_ts?strtotime($end_ts):time();
            if($search_end_day < $search_start_day&&$search_start_day<=time()){
                $search_end_day = $search_start_day;
            } 
            $mode = $mode->where(DB::raw('UNIX_TIMESTAMP(weixin_ts)'),'>=',$search_start_day);
           
            $mode = $mode->where(DB::raw('UNIX_TIMESTAMP(weixin_ts)'),'<=',$search_end_day);
            
            $request->has('weixin_name')&&!empty($request->input('weixin_name'))&&
            $mode = $mode->where('weixin_name','like','%'.$request->input('weixin_name').'%');

           
            $request->has('weixin_category')&&$request->input('weixin_category')!='all'&&
            $mode = $mode->where('weixin_category',$request->input('weixin_category'));

            
            $request->has('leader')&&$request->input('leader')!='all'&&
            $mode = $mode->where('leader',$request->input('leader'));
            

            $rows = $mode->get();
            if(collect($rows)->isNotEmpty()){$rows=$rows->toArray();}
            $serach=['start_day','end_day','weixin_name','weixin_category','leader'];
            $search_arr =Base::getSearchs($request,$serach);
            $exporturl = urlencode($this->grid()->exportUrl('all'));
            
            $listview = view('admin.weixin.list',
                compact('rows','headers','arrsum','category','channel','leader','exporturl','search_arr'))
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
    
            $content->header('微信信息');
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
    
            $content->header('微信信息');
            $content->description('创建');
    
            $content->body($this->form());
        });
    }

    protected function destory(Request $request){

        $weixin_id = $request->input('weixin_id');
        if (empty($weixin_id)){
            return $reponses = [
                'status' => 1,
                'msg' => '参数不能为空!',
                'data' => []
            ];
        }
        try {
            Weixin::where('weixin_id',$weixin_id)->delete();
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
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(weixin::class, function (Grid $grid) {
    
            $grid->disableRowSelector();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            
            });
            $leaders = Base::getweixinLeader(); 
   
            $categorys = Base::getweixinCategory();
            $grid->weixin_id('微信ID')->sortable();
            $grid->weixin_ts('开发日期')->display(function($ts){
                return date('Y-m-d',strtotime($ts));
            })->sortable();
            $grid->weixin_name('微信名称')->sortable();

            $grid->weixin_category('行业分类')->display(function($id) use($categorys){
                $name ='';
                if($categorys){
                    $name =$categorys[$id];
                }              
                return $name;
            })->sortable();
            $grid->ID('ID')->sortable();
            
            $grid->fans('粉丝数')->sortable();
            $grid->headline('头条')->sortable();
            $grid->secondline('次条')->sortable();
            $grid->thirdline('第三条')->sortable();
            $grid->readers('预估阅读数')->sortable();
            $grid->leader('负责人')->display(function($id) use($leaders){
                $name ='';
                if($leaders){
                    $name =$leaders[$id];
                }
                return $name;
            })->sortable();
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
        return Admin::form(weixin::class, function (Form $form) {
         
            $form->hidden('weixin_id','自增id');
            $form->text('weixin_name','微信名称')->rules('required',['不能为空']);
           
            $form->select('leader','负责人')->options(Base::getWeixinLeader())->rules('required',['不能为空']);
            $form->select('weixin_category','行业分类')->options(Base::getWeixinCategory())->rules('required',['不能为空']);
            $form->text('ID','ID')->rules('required',['不能为空']);
            $form->number('fans','粉丝数');
            $form->text('headline','头条');
            $form->text('secondline','次条');
            $form->text('thirdline','第三条');
            $form->text('readers','预估阅读数');
            $form->text('cases','案例')->rules('required',['不能为空']);
            $form->date('weixin_ts','开发时间')->format('YYYY-MM-DD')->rules('required',['不能为空']);
            $form->textarea('remark','备注');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
    
 
    
   
}

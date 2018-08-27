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
use App\Models\Weibo;
use Illuminate\Support\Facades\DB;


class WeiboController extends Controller
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
    
            $content->header('微博媒体');
            $content->description('列表'); 
            $headers = ['开发日期','微博名称','微博分类','粉丝数','直发价','转发价','案例','微任务直发','微任务转发','负责人','备注','操作'];
          
            //获取各个分类
            $category=Base::getWeiboCategory();
         
            $leader = Base::getWeiboLeader();
            
            //搜索结果
            $rows =[];
            $arrsum =[];
            // DB::connection()->enableQueryLog();
            $mode= new Weibo(); 
           
            $start_ts = $request->input('start_day');
            $end_ts = $request->input('end_day');
            $search_start_day= $start_ts?strtotime($start_ts):strtotime('-7 day 00:00:00');
            $search_end_day= $end_ts?strtotime($end_ts):time();
            if($search_end_day < $search_start_day&&$search_start_day<=time()){
                $search_end_day = $search_start_day;
            } 
            $mode = $mode->where(DB::raw('UNIX_TIMESTAMP(weibo_ts)'),'>=',$search_start_day);
           
            $mode = $mode->where(DB::raw('UNIX_TIMESTAMP(weibo_ts)'),'<=',$search_end_day);
            
            $request->has('weibo_name')&&!empty($request->input('weibo_name'))&&
            $mode = $mode->where('weibo_name','like','%'.$request->input('weibo_name').'%');

           
            $request->has('weibo_category')&&$request->input('weibo_category')!='all'&&
            $mode = $mode->where('weibo_category',$request->input('weibo_category'));

            
            $request->has('leader')&&$request->input('leader')!='all'&&
            $mode = $mode->where('leader',$request->input('leader'));
            

            $rows = $mode->get();
            // dump(DB::getQueryLog());
            if(collect($rows)->isNotEmpty()){$rows=$rows->toArray();}
            
            $exporturl = urlencode($this->grid()->exportUrl('all'));
            
            $listview = view('admin.weibo.list',
                compact('rows','headers','arrsum','category','channel','leader','exporturl'))
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
    
            $content->header('微博信息');
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
    
            $content->header('微博信息');
            $content->description('创建');
    
            $content->body($this->form());
        });
    }

    protected function destory(Request $request){

        $weibo_id = $request->input('weibo_id');
        if (empty($weibo_id)){
            return $reponses = [
                'status' => 1,
                'msg' => '参数不能为空!',
                'data' => []
            ];
        }
        try {
            Weibo::where('weibo_id',$weibo_id)->delete();
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
        return Admin::grid(Weibo::class, function (Grid $grid) {
    
            $grid->disableRowSelector();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            
            });
            $leaders = Base::getWeiboLeader(); 
   
            $categorys = Base::getWeiboCategory();
            $grid->weibo_id('微博ID')->sortable();
            $grid->weibo_ts('开发日期')->display(function($ts){
                return date('Y-m-d',strtotime($ts));
            })->sortable();
            $grid->weibo_name('微博名称')->sortable();

            $grid->Weibo_category('微博分类')->display(function($id) use($categorys){
                $name ='';
                if($categorys){
                    $name =$categorys[$id];
                }              
                return $name;
            })->sortable();
      
            $grid->fans('粉丝数')->sortable();
            $grid->direct_price('直发价')->sortable();
            $grid->forward_price('转发价格')->sortable();
            $grid->direct_microtask('微任务直发')->sortable();
            $grid->forward_microtask('微任务转发')->sortable();
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
        return Admin::form(Weibo::class, function (Form $form) {
         
            $form->hidden('weibo_id','微博ID');
            $form->text('weibo_name','微博名称')->rules('required',['不能为空']);
            $form->select('leader','负责人')->options(Base::getWeiboLeader())->rules('required',['不能为空']);
            $form->select('weibo_category','微博分类')->options(Base::getWeiboCategory())->rules('required',['不能为空']);
            $form->number('fans','粉丝数');
            $form->number('direct_price','直发价');
            $form->number('forward_price','转发价');
            $form->text('direct_microtask','微任务直发');
            $form->text('forward_microtask','微任务转发');
            $form->text('cases','案例');
            $form->date('weibo_ts','开发时间')->format('YYYY-MM-DD')->rules('required',['不能为空']);
            $form->textarea('remark','备注');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '修改时间');
        });
    }
    
 
    
   
}

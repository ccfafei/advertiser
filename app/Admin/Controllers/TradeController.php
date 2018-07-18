<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Form;
use Excel;


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
    
            $content->header('媒体信息');
            $content->description('列表');
           
            //$content->body($this->grid());
        });
    }
    
    public function import(){
        return Admin::content(function (Content $content) {
            $content->header('业务报表');          
            $content->body(view('admin.excel.import'));
        });
    }
    
    public function check(Request $request){
        return Admin::content(function (Content $content) use($request) {
            $content->header('Excel数据确认');
            if(!$request->hasFile('file')){
                exit('上传文件为空！');
            }
            $file = $_FILES;
            $excel_file_path = $file['file']['tmp_name'];
            Excel::load($excel_file_path, function($reader) use( &$result) {
                $reader->setDateFormat('Y-m-d');
                $reader = $reader->getSheet(0);                
                $result = $reader->toArray();
            });
           
            $excelView = view('admin.excel.read',compact('result'))
            ->render();
            $content->row($excelView);
           
        });
    
    }

}


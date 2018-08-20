<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Excel;
use App\Admin\Controllers\Base;
use App\Models\Trade;
use Encore\Admin\Widgets\Alert;


class ImportExcelController extends Controller
{
    //excel导入
    public function import(){
        return Admin::content(function (Content $content) {
            $content->header('上传Excel报表');          
            $content->body(view('admin.excel.import'));
        });
    }
    
    //导入数据预览    
    public function check(Request $request){
        if(!$request->hasFile('file')){
            admin_toastr('上传失败','error');
            return redirect(url("/admin/exceltrade/import" ));

        }
        return Admin::content(function (Content $content) use($request) {
            $content->header('Excel数据确认');
      
            $error=0;
            $file = $_FILES;
            $excel_file_path = $file['file']['tmp_name'];
            Excel::load($excel_file_path, function($reader) use(&$rows){
                $reader = $reader->getSheet(0); 
                $rows= $reader->toArray();
            });
            $flag =0;
            $result =[];
            $headers=[];
            //处理相关数据
            foreach ($rows as $key=>$val){
                
                if($key==0){
                    $headers =array_merge(['是否错误','序号'],$val);
                }else{
                    $result[$key]['error'] =[];
                    $result[$key]['num'] =$key;
                    //时间
                    if (preg_match('/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $val[0])) {
                        $date=gmdate("Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($val[0]));
                    }else{
                        $date=\PHPExcel_Style_NumberFormat::toFormattedString($val[0],\PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2	);
                    }
                    $result[$key]['trade_ts']=$date;
                    if(strtotime($date)==false){
                        $flag=1;
                        array_push( $result[$key]['error'],1001);
                    }
                    
                    //客户
                    $result[$key]['customer_name']=$val[1];
//                    $customer = Base::getCustomer($val[1]);
//                    if(!empty($customer)){
//                        $result[$key]['customer_id']=$customer['customer_id'];
//                    }else{
//                        $flag=1;
//                        $result[$key]['customer_id']=0;
//                        array_push( $result[$key]['error'],1002);
//                    }
                    
                    //媒体
                    $result[$key]['media_name']=$val[2];
                    /*
                    $media = Base::getMedia($val[2]);
                    if(!empty($media)){
                        $result[$key]['media_id']=$media['media_id'];
                    }else{
                        $flag=1;
                        $result[$key]['media_id']=0;
                        array_push( $result[$key]['error'],1003);
                    }
                    */
                   
                    //标题
                    $result[$key]['contribution']=$val[3];
                   
                    if(empty($val[3])){
                      $flag=1;           
                      array_push( $result[$key]['error'],1004);
                    }
                    //项目链接
                    $result[$key]['project']=$val[4];
                    
                    //字数
                    $result[$key]['words']=$val[5];
                    
                    //单价
                    $result[$key]['price']=$val[6];
                    
                    //报价
                    $result[$key]['customer_price']=$val[7];
                    /*
                    if((int)$val[7]<=0){
                        $flag=1;
                        array_push( $result[$key]['error'],1005);
                    }
                    */
                    
                    //媒体款
                    $result[$key]['media_price']=$val[8];
                    /*
                    if((int)$val[8]<=0){
                        $flag=1;
                        array_push( $result[$key]['error'],1006);
                    }else{
                        if((int)$val[8]>=(int)$val[7]){
                            $flag=1;
                            array_push( $result[$key]['error'],1007);
                        }
                    }
                  */
                   
                    //利润
                    $result[$key]['profit']=$val[9];
                    if( $val[7]-$val[8] != $val[9] ){
                        $flag=1;
                        array_push( $result[$key]['error'],1008);
                    }
                    
                    //是否回款
                    $result[$key]['is_received']=$val[10];                    
                    //是是否出款
                    $result[$key]['is_paid']=$val[11];
                }                
            }          
 
            $excelView = view('admin.excel.read',compact('result','headers','flag'))
            ->render();
            $content->row($excelView);
           
        });
    
    }
    public function saveExcel(Request $request){
     
            $excel_data = $request->input('exceldata');
            $rows = json_decode(base64_decode($excel_data),true);
            foreach ($rows as $key=>$value){
                unset($rows[$key]['error']);
                unset($rows[$key]['num']);
                if(empty($value['is_paid'])){
                    $rows[$key]['is_paid']=0;
                }
                $rows[$key]['trade_ts']=strtotime($value['trade_ts']);
                $rows[$key]['leader']=Admin::user()->name;
            }
        
            //保存数据   
            try{
                $rs=Trade::insert($rows);
                $data =['data'=>$rows,'status'=>1,'message'=>'保存成功'];
                return response()->json($data);
            }catch (\Exception $e){
                $data =['data'=>$rows,'status'=>0,'message'=>'保存失败'];
                return response()->json($data);
            }

    }
}





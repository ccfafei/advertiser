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
use App\Models\Media;

class ImportMediaExcelController extends Controller
{
    // excel导入
    public function import()
    {
        return Admin::content(function (Content $content)
        {
            $content->header('上传Excel报表');
            $content->body(view('admin.excel.media'));
        });
    }
    
    // 导入后判断数据格式是否正确
    public function save(Request $request)
    {
        if (! $request->hasFile('file')) {
            admin_toastr('上传失败', 'error');
            return redirect(url("/admin/excelmedia/import"));
        }
        
        $file = $_FILES;
        $excel_file_path = $file['file']['tmp_name'];
        Excel::load($excel_file_path, function ($reader) use(&$rows)
        {
            $reader = $reader->getSheet(0);
            $rows = $reader->toArray();
        });
        $result = [];
        // 处理相关数据
        foreach ($rows as $key => $val) {
            if($key==0){
                continue;
            }
            // 时间
            if (preg_match('/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $val[0])) {
                $date = gmdate("Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($val[0]));
            } else {
                $date = \PHPExcel_Style_NumberFormat::toFormattedString($val[0], \PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
            }

            if (strtotime($date) == false) {
                admin_toastr( '第' . ($key + 1) . '行时间格式不正确!', 'error');
                return redirect(url("/admin/excelmedia/import"));
            }
            $date =date('Y-m-d H:i:s ',strtotime($date));
            $result[$key]['media_ts'] = $date;
            //区域
            $result[$key]['area'] = $val[1];

            // 媒体名称
            if (empty($val[2])) {
                admin_toastr( '第' . ($key + 1) . '行媒体名称不能为空', 'error');
                return redirect(url("/admin/excelmedia/import"));
            }
            $result[$key]['media_name'] = $val[2];
            $media = Base::getMedia($val[2]);
            if (! empty($media)) {
                admin_toastr( '第' . ($key + 1) . '行媒体名称已经存在，不能重复录入', 'error');
                return redirect(url("/admin/excelmedia/import"));
    
            }
            
            // 媒体分类
            if (empty($val[3])) {
                admin_toastr( '第' . ($key + 1) . '行媒体分类不能为空', 'error');
                return redirect(url("/admin/excelmedia/import"));
            }
            $getcategorys = Base::getCategory();
            $category = array_flip($getcategorys);
            $category_name = trim($val[3]);
            if (!key_exists($category_name,$category)) {
                admin_toastr( '第' . ($key + 1) . '行媒体分类未录入', 'error');
                return redirect(url("/admin/excelmedia/import"));
            }
            $result[$key]['category'] = $category[$category_name];

            // 媒体频道
            if (empty($val[4])) {
                admin_toastr( '第' . ($key + 1) . '行频道不能为空', 'error');
                return redirect(url("/admin/excelmedia/import"));
            }
            
            $get_channels = Base::getChannel();
            $channels = array_flip($get_channels);
            $channel_name = trim($val[4]);
            if (!array_key_exists($channel_name,$channels)) {
                admin_toastr( '第' . ($key + 1) . '行媒体频道未录入', 'error');
                return redirect(url("/admin/excelmedia/import"));
            }
            $result[$key]['channel'] = $channels[$channel_name];

            // 价格
            $result[$key]['price'] = $val[5];
            
            // 收录
            $result[$key]['collection'] = $val[6];
            
            // 案例
            $result[$key]['cases'] = $val[7];
            
            // 负责人
            if (empty($val[8])) {
                admin_toastr( '第' . ($key + 1) . '行媒体负责人不能为空', 'error');
                return redirect(url("/admin/excelmedia/import"));
            }
            $getleaders = Base::getLeader();
            $leaders = array_flip($getleaders);
            $leader_name = trim($val[8]);
            if (!array_key_exists($leader_name,$leaders)) {
                admin_toastr( '第' . ($key + 1) . '行媒体负责人未录入', 'error');
                return redirect(url("/admin/excelmedia/import"));
            }
            $result[$key]['leader'] = $leaders[$leader_name];

            //备注
            $result[$key]['remark'] = $val[9];
            
            //结束验证
        }
        
        //保存excel数据插入到表
        if(!empty($result)){
             $rs = Media::insert($result);
              if($rs) {
                  admin_toastr('数据保存成功');
                  return redirect(url("/admin/media"));
              }
            }else{
                admin_toastr('数据保存失败，请重试', 'error');
                return redirect(url("/admin/excelmedia/import"));
            }
        }
        

}





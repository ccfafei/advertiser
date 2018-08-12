<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Excel;
use App\Admin\Controllers\Base;
use App\Models\Weibo;
use Encore\Admin\Widgets\Alert;


class ImportWeiboExcelController extends Controller
{
    // excel导入
    public function import()
    {
        return Admin::content(function (Content $content)
        {
            $content->header('上传Excel报表');
            $content->body(view('admin.excel.weibo'));
        });
    }

    // 导入后判断数据格式是否正确
    public function save(Request $request)
    {
        if (! $request->hasFile('file')) {
            admin_toastr('上传失败', 'error');
            return redirect(url("/admin/excelweibo/import"));
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
                return redirect(url("/admin/excelweibo/import"));
            }
            $date =date('Y-m-d H:i:s ',strtotime($date));
            $result[$key]['weibo_ts'] = $date;

            // 微博名称
            if (empty($val[1])) {
                admin_toastr( '第' . ($key + 1) . '行微博名称不能为空', 'error');
                return redirect(url("/admin/excelweibo/import"));
            }
            $result[$key]['weibo_name'] = $val[1];
            $weibo = Base::getWeibo($val[1]);
            if (! empty($weibo)) {
                admin_toastr( '第' . ($key + 1) . '行微博名称已经存在，不能重复录入', 'error');
                return redirect(url("/admin/excelweibo/import"));

            }

            // 微博分类
            if (empty($val[2])) {
                admin_toastr( '第' . ($key + 1) . '行微博分类不能为空', 'error');
                return redirect(url("/admin/excelweibo/import"));
            }
            $getcategorys = Base::getWeiboCategory();
            $category = array_flip($getcategorys);
            $category_name = trim($val[2]);
            if (!key_exists($category_name,$category)) {
                admin_toastr( '第' . ($key + 1) . '行微博分类未录入', 'error');
                return redirect(url("/admin/excelweibo/import"));
            }
            $result[$key]['weibo_category'] = $category[$category_name];

            // 微博粉丝
            if (empty($val[3])) {
                admin_toastr( '第' . ($key + 1) . '行粉丝数不能为空', 'error');
                return redirect(url("/admin/excelweibo/import"));
            }

            $result[$key]['fans'] = $val[3];

            // 直发价
            $result[$key]['direct_price'] = $val[4];

            // 转发价
            $result[$key]['forward_price'] = $val[5];

            // 案例
            $result[$key]['cases'] = $val[6];

            // 微博直发数
            $result[$key]['direct_microtask'] = $val[7];

            // 转发数
            $result[$key]['forward_microtask'] = $val[8];


            // 负责人
            if (empty($val[9])) {
                admin_toastr( '第' . ($key + 1) . '行微博负责人不能为空', 'error');
                return redirect(url("/admin/excelweibo/import"));
            }
            $getleaders = Base::getWeiboLeader();
            $leaders = array_flip($getleaders);
            $leader_name = trim($val[9]);
            if (!array_key_exists($leader_name,$leaders)) {
                admin_toastr( '第' . ($key + 1) . '行微博负责人未录入', 'error');
                return redirect(url("/admin/excelweibo/import"));
            }
            $result[$key]['leader'] = $leaders[$leader_name];

            //备注
            $result[$key]['remark'] = $val[10];

            //结束验证
        }

        //保存excel数据插入到表
        if(!empty($result)){
            $rs = Weibo::insert($result);
            if($rs) {
                admin_toastr('数据保存成功');
                return redirect(url("/admin/weibo"));
            }
        }else{
            admin_toastr('数据保存失败，请重试', 'error');
            return redirect(url("/admin/excelweibo/import"));
        }
    }

}





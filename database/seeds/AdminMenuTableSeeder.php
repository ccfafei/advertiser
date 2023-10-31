<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => '主页',
                'icon' => 'fa-home',
                'uri' => '/',
                'created_at' => NULL,
                'updated_at' => '2018-07-07 18:10:28',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 30,
                'title' => '权限设置',
                'icon' => 'fa-wrench',
                'uri' => NULL,
                'created_at' => NULL,
                'updated_at' => '2018-08-07 04:29:37',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 31,
                'title' => '用户管理',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'created_at' => NULL,
                'updated_at' => '2018-08-07 04:29:37',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 32,
                'title' => '角色管理',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'created_at' => NULL,
                'updated_at' => '2018-08-07 04:29:37',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 33,
                'title' => '权限管理',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'created_at' => NULL,
                'updated_at' => '2018-08-07 04:29:37',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 34,
                'title' => '菜单管理',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'created_at' => NULL,
                'updated_at' => '2018-08-07 04:29:37',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 0,
                'order' => 35,
                'title' => '日志查询',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'created_at' => NULL,
                'updated_at' => '2018-08-07 04:29:37',
            ),
            7 => 
            array (
                'id' => 10,
                'parent_id' => 0,
                'order' => 2,
                'title' => '客户管理',
                'icon' => 'fa-user-md',
                'uri' => NULL,
                'created_at' => '2018-07-12 23:57:00',
                'updated_at' => '2018-07-14 14:51:39',
            ),
            8 => 
            array (
                'id' => 11,
                'parent_id' => 10,
                'order' => 3,
                'title' => '客户信息管理',
                'icon' => 'fa-bars',
                'uri' => '/customer',
                'created_at' => '2018-07-13 00:03:21',
                'updated_at' => '2018-07-14 14:58:08',
            ),
            9 => 
            array (
                'id' => 12,
                'parent_id' => 0,
                'order' => 5,
                'title' => '网络媒体管理',
                'icon' => 'fa-video-camera',
                'uri' => NULL,
                'created_at' => '2018-07-14 14:57:55',
                'updated_at' => '2018-07-31 00:27:10',
            ),
            10 => 
            array (
                'id' => 13,
                'parent_id' => 12,
                'order' => 6,
                'title' => '媒体查询',
                'icon' => 'fa-align-center',
                'uri' => '/media/',
                'created_at' => '2018-07-14 15:38:59',
                'updated_at' => '2018-08-01 03:17:24',
            ),
            11 => 
            array (
                'id' => 14,
                'parent_id' => 12,
                'order' => 8,
                'title' => '频道添加',
                'icon' => 'fa-bars',
                'uri' => '/mediachannel',
                'created_at' => '2018-07-14 15:43:55',
                'updated_at' => '2018-08-01 23:58:49',
            ),
            12 => 
            array (
                'id' => 15,
                'parent_id' => 12,
                'order' => 9,
                'title' => '媒体分类',
                'icon' => 'fa-bars',
                'uri' => '/mediacategory',
                'created_at' => '2018-07-14 15:50:34',
                'updated_at' => '2018-08-01 23:59:03',
            ),
            13 => 
            array (
                'id' => 16,
                'parent_id' => 0,
                'order' => 21,
                'title' => '业务流量表',
                'icon' => 'fa-trademark',
                'uri' => NULL,
                'created_at' => '2018-07-14 15:53:55',
                'updated_at' => '2018-08-07 04:29:37',
            ),
            14 => 
            array (
                'id' => 17,
                'parent_id' => 12,
                'order' => 10,
                'title' => '负责人录入',
                'icon' => 'fa-bars',
                'uri' => '/medialeader',
                'created_at' => '2018-07-14 15:55:36',
                'updated_at' => '2018-08-01 23:59:18',
            ),
            15 => 
            array (
                'id' => 18,
                'parent_id' => 0,
                'order' => 26,
                'title' => '财务报表',
                'icon' => 'fa-dollar',
                'uri' => '/finance',
                'created_at' => '2018-07-14 16:10:54',
                'updated_at' => '2018-08-07 04:29:37',
            ),
            16 => 
            array (
                'id' => 19,
                'parent_id' => 10,
                'order' => 4,
                'title' => '客户录入',
                'icon' => 'fa-bars',
                'uri' => '/customer/create',
                'created_at' => '2018-07-18 01:09:39',
                'updated_at' => '2018-07-21 13:57:30',
            ),
            17 => 
            array (
                'id' => 20,
                'parent_id' => 16,
                'order' => 25,
                'title' => '导入excel',
                'icon' => 'fa-bars',
                'uri' => '/exceltrade/import',
                'created_at' => '2018-07-18 01:12:44',
                'updated_at' => '2018-08-07 04:29:37',
            ),
            18 => 
            array (
                'id' => 21,
                'parent_id' => 16,
                'order' => 22,
                'title' => '业务查看',
                'icon' => 'fa-bars',
                'uri' => '/trade',
                'created_at' => '2018-07-18 01:16:37',
                'updated_at' => '2018-08-07 04:29:37',
            ),
            19 => 
            array (
                'id' => 22,
                'parent_id' => 16,
                'order' => 24,
                'title' => '人工录入',
                'icon' => 'fa-bars',
                'uri' => '/trade/create',
                'created_at' => '2018-07-25 23:17:50',
                'updated_at' => '2018-08-07 04:29:37',
            ),
            20 => 
            array (
                'id' => 23,
                'parent_id' => 16,
                'order' => 23,
                'title' => '审核及修改',
                'icon' => 'fa-bars',
                'uri' => '/trade/check',
                'created_at' => '2018-07-25 23:19:06',
                'updated_at' => '2018-08-07 04:29:37',
            ),
            21 => 
            array (
                'id' => 24,
                'parent_id' => 18,
                'order' => 28,
                'title' => '回款报表',
                'icon' => 'fa-calendar-check-o',
                'uri' => '/report/receive',
                'created_at' => '2018-07-27 23:49:01',
                'updated_at' => '2018-08-07 04:29:37',
            ),
            22 => 
            array (
                'id' => 25,
                'parent_id' => 18,
                'order' => 29,
                'title' => '出款报表',
                'icon' => 'fa-camera-retro',
                'uri' => '/report/paid',
                'created_at' => '2018-07-27 23:50:41',
                'updated_at' => '2018-08-07 04:29:37',
            ),
            23 => 
            array (
                'id' => 26,
                'parent_id' => 0,
                'order' => 11,
                'title' => '微博媒体管理',
                'icon' => 'fa-weibo',
                'uri' => '/weibo',
                'created_at' => '2018-07-31 00:28:33',
                'updated_at' => '2018-08-11 14:36:09',
            ),
            24 => 
            array (
                'id' => 27,
                'parent_id' => 26,
                'order' => 12,
                'title' => '微博查询',
                'icon' => 'fa-bars',
                'uri' => '/weibo',
                'created_at' => '2018-07-31 00:29:25',
                'updated_at' => '2018-08-01 03:26:06',
            ),
            25 => 
            array (
                'id' => 28,
                'parent_id' => 26,
                'order' => 14,
                'title' => '微博分类',
                'icon' => 'fa-bars',
                'uri' => '/weibocategory',
                'created_at' => '2018-07-31 00:45:48',
                'updated_at' => '2018-08-01 23:58:10',
            ),
            26 => 
            array (
                'id' => 29,
                'parent_id' => 26,
                'order' => 15,
                'title' => '负责人录入',
                'icon' => 'fa-bars',
                'uri' => '/weiboleader',
                'created_at' => '2018-07-31 00:46:26',
                'updated_at' => '2018-08-01 23:58:31',
            ),
            27 => 
            array (
                'id' => 30,
                'parent_id' => 12,
                'order' => 7,
                'title' => '媒体录入',
                'icon' => 'fa-bars',
                'uri' => '/media/create',
                'created_at' => '2018-08-01 03:13:47',
                'updated_at' => '2018-08-01 03:14:24',
            ),
            28 => 
            array (
                'id' => 31,
                'parent_id' => 26,
                'order' => 13,
                'title' => '微博录入',
                'icon' => 'fa-bars',
                'uri' => '/weibo/create',
                'created_at' => '2018-08-01 03:15:12',
                'updated_at' => '2018-08-01 03:26:28',
            ),
            29 => 
            array (
                'id' => 32,
                'parent_id' => 18,
                'order' => 27,
                'title' => '财务数据录入',
                'icon' => 'fa-bars',
                'uri' => '/finance',
                'created_at' => '2018-08-02 02:02:55',
                'updated_at' => '2018-08-07 04:29:37',
            ),
            30 => 
            array (
                'id' => 33,
                'parent_id' => 0,
                'order' => 16,
                'title' => '微信媒体管理',
                'icon' => 'fa-weixin',
                'uri' => NULL,
                'created_at' => '2018-08-07 03:37:49',
                'updated_at' => '2018-08-11 14:36:44',
            ),
            31 => 
            array (
                'id' => 34,
                'parent_id' => 33,
                'order' => 17,
                'title' => '微信查询',
                'icon' => 'fa-bars',
                'uri' => '/weixin',
                'created_at' => '2018-08-07 03:39:33',
                'updated_at' => '2018-08-07 03:43:37',
            ),
            32 => 
            array (
                'id' => 35,
                'parent_id' => 33,
                'order' => 18,
                'title' => '微信录入',
                'icon' => 'fa-bars',
                'uri' => '/weixin/create',
                'created_at' => '2018-08-07 03:40:40',
                'updated_at' => '2018-08-07 03:43:37',
            ),
            33 => 
            array (
                'id' => 36,
                'parent_id' => 33,
                'order' => 19,
                'title' => '微信分类',
                'icon' => 'fa-bars',
                'uri' => '/weixincategory',
                'created_at' => '2018-08-07 03:41:31',
                'updated_at' => '2018-08-07 03:43:37',
            ),
            34 => 
            array (
                'id' => 37,
                'parent_id' => 33,
                'order' => 20,
                'title' => '负责人录入',
                'icon' => 'fa-bars',
                'uri' => '/weixinleader',
                'created_at' => '2018-08-07 03:42:48',
                'updated_at' => '2018-08-07 03:43:37',
            ),
            35 => 
            array (
                'id' => 38,
                'parent_id' => 12,
                'order' => 0,
                'title' => 'Excel导入',
                'icon' => 'fa-bars',
                'uri' => '/excelmedia/import',
                'created_at' => '2018-08-11 14:35:07',
                'updated_at' => '2018-08-11 14:35:07',
            ),
            36 => 
            array (
                'id' => 40,
                'parent_id' => 26,
                'order' => 0,
                'title' => 'Excel导入',
                'icon' => 'fa-bars',
                'uri' => '/excelweibo/import',
                'created_at' => '2018-08-12 15:26:40',
                'updated_at' => '2018-08-12 15:26:40',
            ),
            37 => 
            array (
                'id' => 41,
                'parent_id' => 33,
                'order' => 0,
                'title' => 'Excel导入',
                'icon' => 'fa-bars',
                'uri' => '/excelweixin/import',
                'created_at' => '2018-08-12 15:27:03',
                'updated_at' => '2018-08-12 15:27:03',
            ),
        ));
        
        
    }
}
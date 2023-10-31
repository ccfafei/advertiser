<?php

use Illuminate\Database\Seeder;

class AdminPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_permissions')->delete();
        
        \DB::table('admin_permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '所有权限',
                'slug' => '*',
                'http_method' => '',
                'http_path' => '*',
                'created_at' => NULL,
                'updated_at' => '2018-07-07 18:21:51',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '主页',
                'slug' => 'dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
                'created_at' => NULL,
                'updated_at' => '2018-07-07 18:23:31',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '登录',
                'slug' => 'auth.login',
                'http_method' => '',
                'http_path' => '/auth/login
/auth/logout',
                'created_at' => NULL,
                'updated_at' => '2018-07-07 18:25:47',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '用户设置',
                'slug' => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
                'created_at' => NULL,
                'updated_at' => '2018-07-07 18:24:13',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '设置管理权限',
                'slug' => 'auth.management',
                'http_method' => '',
                'http_path' => '/auth/roles
/auth/permissions
/auth/menu
/auth/logs',
                'created_at' => NULL,
                'updated_at' => '2018-07-07 18:24:57',
            ),
            5 => 
            array (
                'id' => 8,
                'name' => '财务权限',
                'slug' => 'finance.all',
                'http_method' => '',
                'http_path' => '/finance*',
                'created_at' => '2018-07-29 10:28:07',
                'updated_at' => '2018-07-29 10:28:07',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => '价格修改',
                'slug' => 'trade.edit',
                'http_method' => 'GET,POST',
                'http_path' => '/trade/{id}/edit',
                'created_at' => '2018-07-21 22:08:34',
                'updated_at' => '2018-07-21 22:22:37',
            ),
            7 => 
            array (
                'id' => 9,
                'name' => '进出款查看',
                'slug' => 'report.view',
                'http_method' => '',
                'http_path' => '/report/receive
/report/paid',
                'created_at' => '2018-07-29 10:30:30',
                'updated_at' => '2018-08-03 23:38:57',
            ),
            8 => 
            array (
                'id' => 10,
                'name' => '信息\\进出款审核',
                'slug' => 'trade.check',
                'http_method' => '',
                'http_path' => 'trade/checkupdate
trade/receiveupdate
trade/paidupdate',
                'created_at' => '2018-08-03 23:38:21',
                'updated_at' => '2018-08-03 23:38:21',
            ),
        ));
        
        
    }
}
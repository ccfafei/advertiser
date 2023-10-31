<?php

use Illuminate\Database\Seeder;

class AdminRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_roles')->delete();
        
        \DB::table('admin_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '管理员',
                'slug' => 'administrator',
                'created_at' => '2018-07-07 08:37:55',
                'updated_at' => '2018-07-07 18:38:08',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '普通用户',
                'slug' => 'users',
                'created_at' => '2018-07-07 18:34:35',
                'updated_at' => '2018-07-07 18:34:35',
            ),
        ));
        
        
    }
}
<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_users')->delete();
        
        \DB::table('admin_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'username' => 'admin',
                'password' => bcrypt('123456'),
                'name' => '管理员',
                'avatar' => 'images/96795c394a7cebb0e92f85661d672e58.jpg',
                'remember_token' => '',
                'created_at' => '2018-07-07 08:37:55',
                'updated_at' => '2020-07-26 00:00:40',
            ),
        ));
        
        
    }
}
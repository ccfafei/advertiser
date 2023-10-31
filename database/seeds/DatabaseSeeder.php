<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminMenuTableSeeder::class,
            AdminPermissionsTableSeeder::class,
            AdminRolesTableSeeder::class,
            AdminUsersTableSeeder::class,
            AdminRolePermissionsTableSeeder::class,
            AdminRoleUsersTableSeeder::class
        ]);
    }
}

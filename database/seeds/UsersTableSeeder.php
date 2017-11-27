<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            'name' => 'jorge',
            'last_name' => 'pined0',
            'email' => 'jpinedom@hotmail.com',
            'role_id' => 1,
            'password' => bcrypt('123')
        ]);
    }
}

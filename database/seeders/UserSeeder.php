<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	DB::table('users')->insert(
            [
                'name'=>'Ketan Kulkarni',
                'email'=>'ketan@carvingit.com',
                'password'=>bcrypt('ketan123'),
                'remember_token'=>0,
                'created_at'=>NOW(),
                'updated_at'=>NOW(),
            ]
        );
	
	DB::table('users')->insert(
            [
                'name'=>'Shraddha Kulkarni',
                'email'=>'shraddha@carvingit.com',
                'password'=>bcrypt('shraddha123'),
                'remember_token'=>0,
                'created_at'=>NOW(),
                'updated_at'=>NOW(),
            ]
        );

	// create default roles

        DB::table('roles')->insert(
            [
                'name'=>'admin'
            ]
        );

        // Make Ketan and Tom admins
        DB::table('user_roles')->insert(
            [
                'user_id'=>1,
                'role_id'=>1
            ]);
        DB::table('user_roles')->insert(
            [
                'user_id'=>2,
                'role_id'=>1
            ],
        );
    }
}

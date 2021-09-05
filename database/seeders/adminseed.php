<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class adminseed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usr = [
            [
                // 'name' => "PUSAT",
                'username' => "admin",
                'email'=> "admin@aw.com",
                'password'   => bcrypt("admin"),
                'created_at' => new \DateTime,
                'updated_at' => null,
            ],
            

        ];
        \DB::table('users')->insert($usr);
    }
}

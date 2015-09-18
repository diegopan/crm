<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         factory(\Crm\Entities\User::class)->create([
            'group_id' => 1,
            'name' =>  "Diego Goulart",
            'username' => 'diego.goulart',
            'password' => bcrypt('123456'),
            'recovery' => bcrypt('Jesus me ama!'),
            'remember_token' => str_random(10),
        ]);

        return factory(\Crm\Entities\User::class, 10)->create();
    }
}

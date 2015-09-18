<?php

use Illuminate\Database\Seeder;

class UserGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return factory(\Crm\Entities\UserGroup::class, 10)->create();
    }
}

<?php

use Illuminate\Database\Seeder;

class PortfolioConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return factory(\Crm\Entities\PortfolioConfig::class, 10)->create();
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserGroupTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(MemberTableSeeder::class);
        $this->call(PortfolioTableSeeder::class);
        $this->call(PortfolioConfigTableSeeder::class);
        $this->call(SaleTableSeeder::class);

        Model::reguard();
    }
}

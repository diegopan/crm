<?php

namespace Crm\Providers;

use Illuminate\Support\ServiceProvider;

class CrmProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("Crm\Repositories\UserGroupRepository","Crm\Repositories\UserGRoupRepositoryEloquent");
        $this->app->bind("Crm\Repositories\ClientRepository","Crm\Repositories\ClientRepositoryEloquent");
        $this->app->bind("Crm\Repositories\TeamRepository","Crm\Repositories\TeamRepositoryEloquent");
        $this->app->bind("Crm\Repositories\MemberRepository","Crm\Repositories\MemberRepositoryEloquent");
        $this->app->bind("Crm\Repositories\PortfolioRepository","Crm\Repositories\PortfolioRepositoryEloquent");
        $this->app->bind("Crm\Repositories\PortfolioConfigRepository","Crm\Repositories\PortfolioConfigRepositoryEloquent");
        $this->app->bind("Crm\Repositories\UserRepository","Crm\Repositories\UserRepositoryEloquent");
        $this->app->bind("Crm\Repositories\SaleRepository","Crm\Repositories\SaleRepositoryEloquent");
        $this->app->bind("Crm\Repositories\PortfolioReschedulingRepository","Crm\Repositories\PortfolioReschedulingRepositoryEloquent");
    }
}

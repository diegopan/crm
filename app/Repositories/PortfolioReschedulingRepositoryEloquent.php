<?php

namespace Crm\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Crm\Entities\PortfolioRescheduling;

/**
 * Class PortfolioReschedulingRepositoryEloquent
 * @package namespace Crm\Repositories;
 */
class PortfolioReschedulingRepositoryEloquent extends BaseRepository implements PortfolioReschedulingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PortfolioRescheduling::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app(RequestCriteria::class) );
    }
}
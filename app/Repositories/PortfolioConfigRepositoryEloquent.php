<?php

namespace Crm\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Crm\Entities\PortfolioConfig;

/**
 * Class PortfolioConfigRepositoryEloquent
 * @package namespace Crm\Repositories;
 */
class PortfolioConfigRepositoryEloquent extends BaseRepository implements PortfolioConfigRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PortfolioConfig::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app(RequestCriteria::class) );
    }
}
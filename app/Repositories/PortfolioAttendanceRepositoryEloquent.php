<?php

namespace Crm\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Crm\Entities\PortfolioAttendance;

/**
 * Class PortfolioAttendanceRepositoryEloquent
 * @package namespace Crm\Repositories;
 */
class PortfolioAttendanceRepositoryEloquent extends BaseRepository implements PortfolioAttendanceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PortfolioAttendance::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app(RequestCriteria::class) );
    }
}
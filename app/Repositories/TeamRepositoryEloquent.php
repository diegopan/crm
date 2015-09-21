<?php

namespace Crm\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Crm\Entities\Team;

/**
 * Class TeamRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TeamRepositoryEloquent extends BaseRepository implements TeamRepository
{

    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Team::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app('Prettus\Repository\Criteria\RequestCriteria') );
    }
}
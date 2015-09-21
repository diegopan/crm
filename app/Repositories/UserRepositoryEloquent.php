<?php

namespace Crm\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Crm\Entities\User;

/**
 * Class UserRepositoryEloquent
 * @package namespace Crm\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{


    protected $fieldSearchable = [
        'username'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app('Prettus\Repository\Criteria\RequestCriteria') );
    }
}
<?php

namespace Crm\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Crm\Entities\UserGroup;

/**
 * Class UserGroupRepositoryEloquent
 * @package namespace Crm\Repositories;
 */
class UserGroupRepositoryEloquent extends BaseRepository implements UserGroupRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserGroup::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app(RequestCriteria::class) );
    }
}
<?php

namespace Crm\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Crm\Entities\Member;

/**
 * Class MemberRepositoryEloquent
 * @package namespace Crm\Repositories;
 */
class MemberRepositoryEloquent extends BaseRepository implements MemberRepository
{

    protected $fieldSearchable = [

        'sap',
        'team_id'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Member::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( app('Prettus\Repository\Criteria\RequestCriteria') );
    }
}
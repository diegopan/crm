<?php

namespace Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PortfolioRescheduling extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'portfolio_id',
        'newtime'
    ];

}

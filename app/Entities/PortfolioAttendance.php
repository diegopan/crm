<?php

namespace Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PortfolioAttendance extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [ 'portfolio_id'];



    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

}

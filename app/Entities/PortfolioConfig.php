<?php

namespace Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PortfolioConfig extends Model implements Transformable
{

    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = [
        "portfolio_id",
        "seg",
        "ter",
        "qua",
        "qui",
        "sex"
    ];

    protected $dates = ['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

}

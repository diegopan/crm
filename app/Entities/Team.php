<?php

namespace Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Team extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = [ 'name', 'slug', 'type'];

    protected $dates = ['deleted_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class);
    }


    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }


    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

}

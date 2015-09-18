<?php

namespace Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Client extends Model implements Transformable
{
    use SoftDeletes;
    use TransformableTrait;


    protected $fillable = [
        "cod",
        "cnpj",
        "razao",
        "uf",
        "phone"
    ];

    protected $dates = ['deleted_at'];





    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function portfolio()
    {
        return $this->hasOne(Portfolio::class);
    }



    public function sales()
    {
        return $this->hasMany(Sale::class);
    }


}

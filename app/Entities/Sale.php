<?php

namespace Crm\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Sale extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'member_id',
        'team_id',
        'number',
        'value',
        'tags',
        'obs'
    ];

    protected $dates = ['deleted_at'];


    public function member()
    {
        return $this->belongsTo(Member::class);
    }


    public function team()
    {
        return $this->belongsTo(Team::class);
    }


    public function client()
    {
        return $this->belongsTo(Client::class);
    }




}

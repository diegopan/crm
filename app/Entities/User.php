<?php


namespace Crm\Entities;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;



class User extends Model implements Transformable, AuthenticatableContract, CanResetPasswordContract
{
    use TransformableTrait, Authenticatable, CanResetPassword, SoftDeletes;

    protected $fillable = ['group_id','name', 'username', 'password','recovery'];
    protected $hidden = ['password', 'recovery', 'remember_token'];




    protected $dates = ['deleted_at'];

    public function member()
    {
        return $this->hasOne(Member::class);
    }


    public function group()
    {
        return $this->belongsTo(UserGroup::class);
    }

}

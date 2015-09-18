<?php
/**
 * Created by PhpStorm.
 * User: diego
 * Date: 03/08/2015
 * Time: 13:47
 */

namespace Crm\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class MemberValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            "user_id"    => "required|integer|unique:members",
            "team_id"    => "required|integer",
            "sap"        => "required|unique:members|max:8",
        ],
        ValidatorInterface::RULE_UPDATE => [
            "user_id"    => "sometimes|required|integer|unique:members",
            "team_id"    => "sometimes|required|integer",
            "sap"        => "sometimes|required|unique:members|max:8",
        ]
    ];

}
<?php


namespace Crm\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class UserGroupValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            "name"      => "required|unique:user_groups|max:50",
        ],
        ValidatorInterface::RULE_UPDATE => [
            "name"      => "required|unique:user_groups|max:50",
        ]
    ];

}
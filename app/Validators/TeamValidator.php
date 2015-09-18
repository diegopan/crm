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

class TeamValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            "name"      => "required|unique:teams|max:50|min:2",
            "slug"      => "required|unique:teams|max:20|min:2",
            "type"      => "required|integer",
        ],
        ValidatorInterface::RULE_UPDATE => [
            "name"      => "sometimes|required|unique:teams|max:50|min:2",
            "slug"      => "sometimes|required|unique:teams|max:20|min:2",
            "type"      => "sometimes|required|integer",
        ]
    ];

}
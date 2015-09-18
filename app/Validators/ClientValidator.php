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

class ClientValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            "cod"   => "required|unique:clients|max:10",
            "cnpj"  => "required|unique:clients|max:14",
            "razao" => "required|max:255",
            "uf"    => "required|max:2",
            "phone" => "required|max:11"
        ],
        ValidatorInterface::RULE_UPDATE => [
            "cod"   => "sometimes|required|unique:clients|max:10",
            "cnpj"  => "sometimes|required|unique:clients|max:14",
            "razao" => "sometimes|required|max:255",
            "uf"    => "sometimes|required|max:2",
            "phone" => "sometimes|required|max:11"
        ]
    ];

}
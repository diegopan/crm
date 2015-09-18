<?php


namespace Crm\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SaleValidator extends LaravelValidator
{


    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            "client_id"     => "required|integer|exists:clients,id",
            "team_id"       => "required|integer|exists:teams,id",
            "member_id"     => "required|integer|exists:members,id",
            "number"        => "required|unique:sales",
            "value"         => "required"
        ],
        ValidatorInterface::RULE_UPDATE => [
            "client_id"     => "sometimes|required|integer|exists:clients,id",
            "team_id"       => "sometimes|required|integer|exists:teams,id",
            "member_id"     => "sometimes|required|integer|exists:members,id",
            "number"        => "sometimes|required|unique:sales",
            "value"         => "sometimes|required"
        ]
    ];



}
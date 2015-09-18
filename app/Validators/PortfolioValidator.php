<?php


namespace Crm\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class PortfolioValidator extends LaravelValidator
{



    protected $messages = [
        'Cliente.unique' => 'Já existe uma carteira cadastrada para este cliente.',
    ];

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            "client_id"     => "required|integer|exists:clients,id|unique:portfolios",
            "team_id"       => "required|integer|exists:teams,id",
            "member_id"     => "required|integer|exists:members,id",
            "responsible"   => "max:255"
        ],
        ValidatorInterface::RULE_UPDATE => [
            "client_id"     => "sometimes|required|integer|exists:clients,id|unique:portfolios",
            "team_id"       => "sometimes|required|integer|exists:teams,id",
            "member_id"     => "sometimes|required|integer|exists:members,id",
            "responsible"   => "max:255"
        ]
    ];



}
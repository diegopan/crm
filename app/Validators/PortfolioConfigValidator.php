<?php

namespace Crm\Validators;


use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class PortfolioConfigValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            "portfolio_id"      => "required|integer|exists:portfolios,id|unique:portfolio_configs",
            "seg"               => "date_format:H:i:s",
            "ter"               => "date_format:H:i:s",
            "qua"               => "date_format:H:i:s",
            "qui"               => "date_format:H:i:s",
            "sex"               => "date_format:H:i:s"
        ],
        ValidatorInterface::RULE_UPDATE => [
            "portfolio_id"      => "sometimes|required|integer|exists:portfolios,id|unique:portfolio_configs",
            "seg"               => "sometimes|date_format:H:i:s",
            "ter"               => "sometimes|date_format:H:i:s",
            "qua"               => "sometimes|date_format:H:i:s",
            "qui"               => "sometimes|date_format:H:i:s",
            "sex"               => "sometimes|date_format:H:i:s"
        ]
    ];

}
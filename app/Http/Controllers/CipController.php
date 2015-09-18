<?php

namespace Crm\Http\Controllers;


use Crm\Services\CipService;

class CipController extends Controller
{

    private $service;


    /**
     * @param CipService $service
     */
    public function __construct(CipService $service){

        $this->service = $service;
    }



    public function getTrimestralCnpj($cnpj){

        return $this->service->getTrimestralCnpj($cnpj);

    }

    public function getTrimestralCarteira($carteira){

        return $this->service->getTrimestralCarteira($carteira);

    }
}

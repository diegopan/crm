<?php

namespace Crm\Http\Controllers;


use Crm\Services\StatusService;

class StatusController extends Controller
{
    /**
     * @var StatusService
     */
    private $service;


    /**
     * @param StatusService $service
     */
    public function __construct(StatusService $service){

        $this->service = $service;
    }



    public function getDailyStatusByMember($memberId){

        return $this->service->getDailyStatusByMember($memberId);

    }


    public function getMonthlyStatusByMember($memberId){

        return $this->service->getMonthlyStatusByMember($memberId);

    }

}

<?php

namespace Crm\Http\Controllers;

use Crm\Services\PortfolioService;
use Illuminate\Http\Request;
use Crm\Http\Requests;

class PortfolioController extends Controller
{


    /**
     * @var PortfolioService
     */
    private $service;

    public function __construct(PortfolioService $service)
    {

        $this->service = $service;
    }

    /**
     * @param $member_id
     * @return mixed
     */
    public function index()
    {
        return $this->service->getAll();
    }



   public function listAll($member_id){
       return $this->service->listAll($member_id);
   }


    /**
     * @param $member_id
     * @return mixed
     */
    public function indexByMember($member_id)
    {
        return $this->service->getAll($member_id);
    }


    /**
     * @param $team_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexByTeam($team_id)
    {
        return $this->service->getAllByTeam($team_id);
    }


    /**
     * @param $client_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexByClient($client_id)
    {
        return $this->service->getAllByClient($client_id);
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->store($request->all());
    }


    /**
     * Store many resources in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function storeMany(Request $request)
    {
        return $this->service->storeMany($request->all());
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->service->show($id);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }



    public function reschedule(Request $request, $id)
    {
        return $this->service->reschedule($request->all(), $id);
    }
}

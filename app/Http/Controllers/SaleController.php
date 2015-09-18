<?php

namespace Crm\Http\Controllers;

use Crm\Services\SaleService;
use Illuminate\Http\Request;

use Crm\Http\Requests;
use Crm\Http\Controllers\Controller;

class SaleController extends Controller
{

    /**
     * @var SaleService
     */
    private $service;

    /**
     * @param SaleService $service
     */
    public function __construct(SaleService $service)
    {
        $this->service = $service;
    }



    public function getByCli($cliId, $memberId)
    {

        return $this->service->getByClient($cliId, $memberId);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }



    public function getTags($cliId, $memberId){
        return $this->service->getLastTags($cliId, $memberId);
    }



    public function getHistory( $memberId,$cliId){
        return $this->service->getHistoryByClient( $memberId,$cliId);
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
}

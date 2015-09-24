<?php

namespace Crm\Http\Controllers;

use Crm\Services\AttendanceService;
use Illuminate\Http\Request;

use Crm\Http\Requests;
use Crm\Http\Controllers\Controller;

class PortfolioAttendanceController extends Controller
{

    /**
     * @var AttendanceService
     */
    private $service;

    /**
     * @param AttendanceService $service
     */
    public function __construct(AttendanceService $service){

        $this->service = $service;
    }



    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->service->getAll();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->save($request->all());
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
}

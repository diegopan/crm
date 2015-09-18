<?php

namespace Crm\Http\Controllers;


use Crm\Services\TeamService;
use Illuminate\Http\Request;
use Crm\Http\Requests;

class TeamController extends Controller
{

    /**
     * @var TeamService
     */
    private $service;

    /**
     * @param TeamService $service
     */
    public function __construct(TeamService $service){
        $this->service = $service;
    }


    public function searchToSelect()
    {
        return $this->service->getAll();
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
     * Retorna os membros de uma equipe.
     *
     * @return Response
     */
    public function getMembers($id)
    {
        return $this->service->getMembers($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
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
       return $this->service->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
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
